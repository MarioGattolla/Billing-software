<?php

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    $request = \Illuminate\Http\Request::create(route('categories.create'), 'POST', [
        'name' => 'Test Name',
        'description' => 'Test Description',

    ]);

    $response = app(CategoryController::class)->store($request);

    /** @var Category $category */
    $category = Category::findOrFail(1);

    expect($category->name)->toBe('Test Name');
    expect($category->description)->toBe('Test Description');

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


    /** @var Category $old_category */
    $old_category = Category::factory()->create([
        'name' => 'Test Name',
        'description' => 'Test Description',
    ]);

    allow_authorize('editCategory', $old_category);

    $request = \Illuminate\Http\Request::create(route('categories.edit', $old_category), 'PUT', [
        'name' => 'New Test Name',
        'description' => 'New Test Description',
    ]);

    $response = app(CategoryController::class)->update($request, $old_category);

    /** @var Category $category */
    $category = Category::findOrFail(1);

    expect($category->name)->toBe('New Test Name');
    expect($category->description)->toBe('New Test Description');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('categories.show', $category));

});


test('can delete category and return correct redirect', function () {

    /** @var Category $category */
    $category = Category::factory()->create();

    allow_authorize('deleteCategory', $category);

    $response = app(CategoryController::class)->destroy($category);

    expect(Category::count())->toBe(0);
    expect($response)->toBeRedirect(route('categories.index'));

});
