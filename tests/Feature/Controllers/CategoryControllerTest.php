<?php

use App\Http\Controllers\CategoryController;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;


uses(RefreshDatabase::class);


test('categories index return correct view', function () {

    allow_authorize('viewAny', Category::class);

    $response = app(CategoryController::class)->index();

    expect($response)->toBeView('categories.index');

});

test('only authorized user can see index page', function () {

    authorize_check_by_policy('show category', 'viewAny', Category::class);

});

test('categories create return correct view', function () {

    allow_authorize('createCategory', Category::class);

    $response = app(CategoryController::class)->create();

    expect($response)->toBeView('categories.create');

});

test('only authorized user can see create page', function () {

    authorize_check_by_policy('create category', 'createCategory', Category::class);

});

test('can store category and return correct redirect', function () {

    allow_authorize('createCategory', Category::class);

    $translator = $this->createMock(Translator::class);
    $request = new StoreCategoryRequest();
    $validator = new Validator($translator, ['name' => 'Test name', 'parent_id' => null, 'description' => null], $request->rules());

     $validated = $request->setValidator($validator);

     $response = app(CategoryController::class)->store($validated);

    /** @var Category $category */
    $category = Category::findOrFail(1);

    expect($category->name)->toBe('Test name');
    expect($category->description)->toBe(null);
    expect($category->parent_id)->toBe(null);

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('categories.index'));
});

test('can store subcategory and return correct redirect', function () {

    allow_authorize('createCategory', Category::class);

    Category::factory()->create(['name' => 'Test Category']);

    $translator = $this->createMock(Translator::class);
    $request = new StoreCategoryRequest();
    $validator = new Validator($translator, ['name' => 'Test name', 'parent_id' => 1, 'description' => null], $request->rules());

    $validated = $request->setValidator($validator);

    $response = app(CategoryController::class)->store($validated);

    /** @var Category $subcategory */
    $subcategory = Category::find(2);

    expect($subcategory->name)->toBe('Test name');
    expect($subcategory->description)->toBe(null);
    expect($subcategory->parent->name)->toBe('Test Category');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('categories.index'));
});


test('categories show return correct view', function () {

    $category = Category::factory()->make();

    allow_authorize('view', $category);

    $response = app(CategoryController::class)->show($category);

    expect($response)->toBeView('categories.show');

});

test('only authorized user can see categories show page', function () {


    $category = Category::factory()->make();

    authorize_check_by_policy('show category', 'view', $category);

});

test('categories edit return correct view', function () {

    $category = Category::factory()->make();

    allow_authorize('editCategory', $category);

    $response = app(CategoryController::class)->edit($category);

    expect($response)->toBeView('categories.edit');

});

test('only authorized user can see user edit page', function () {

    $category = Category::factory()->make();

    authorize_check_by_policy('edit category', 'editCategory', $category);

});


test('can update category and return correct redirect', function () {

    allow_authorize('editCategory', Category::class);

    $category = Category::factory()->create(['name' => 'Test', 'parent_id' => null]);

    $translator = $this->createMock(Translator::class);
    $request = new StoreCategoryRequest();
    $validator = new Validator($translator, ['name' => 'Test name', 'parent_id' => null, 'description' => null], $request->rules());

    $validated = $request->setValidator($validator);

    $response = app(CategoryController::class)->update($validated, $category);

    /** @var Category $category */
    $category = Category::findOrFail(1);

    expect($category->name)->toBe('Test name');
    expect($category->description)->toBe(null);
    expect($category->parent_id)->toBe(null);

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('categories.show', $category));
});

test('can update subcategory and return correct redirect', function () {

    allow_authorize('editCategory', Category::class);

    Category::factory()->create(['name' => 'Parent', 'parent_id' => null]);

    $subcategory = Category::factory()->create(['name' => 'Test', 'parent_id' => null]);

    $translator = $this->createMock(Translator::class);
    $request = new StoreCategoryRequest();
    $validator = new Validator($translator, ['name' => 'Test name', 'parent_id' => 1, 'description' => null], $request->rules());

    $validated = $request->setValidator($validator);

    $response = app(CategoryController::class)->update($validated, $subcategory);

    /** @var Category $subcategory */
    $subcategory = Category::find(2);

    expect($subcategory->name)->toBe('Test name');
    expect($subcategory->description)->toBe(null);
    expect($subcategory->parent->name)->toBe('Parent');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('categories.show', $subcategory));
});



test('can delete category and return correct redirect', function () {

    /** @var Category $category */
    $category = Category::factory()->create();

    allow_authorize('deleteCategory', $category);

    $response = app(CategoryController::class)->destroy($category);

    expect(Category::count())->toBe(0);
    expect($response)->toBeRedirect(route('categories.index'));

});
