<?php

use App\Http\Controllers\SubcategoryController;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


test('subcategories index return correct view', function () {

    allow_authorize('viewAny', Subcategory::class);

    $response = app(SubcategoryController::class)->index();

    expect($response)->toBeView('subcategories.index');

});

test('only authorized user can see index page', function () {

    authorize_check_by_policy('show subcategory', 'viewAny', Subcategory::class);

});

test('subcategories create return correct view', function () {

    allow_authorize('createSubcategory', Subcategory::class);

    $response = app(SubcategoryController::class)->create();

    expect($response)->toBeView('subcategories.create');

});

test('only authorized user can see create page', function () {

    authorize_check_by_policy('create subcategory', 'createSubcategory', Subcategory::class);

});

test('can store subcategory and return correct redirect', function () {

    allow_authorize('createSubcategory', Subcategory::class);

    $request = \Illuminate\Http\Request::create(route('subcategories.create'), 'POST', [
        'name' => 'Test Name',
        'description' => 'Test Description',

    ]);

    $response = app(SubcategoryController::class)->store($request);

    /** @var Subcategory $subcategory */
    $subcategory = Subcategory::findOrFail(1);

    expect($subcategory->name)->toBe('Test Name');
    expect($subcategory->description)->toBe('Test Description');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('subcategories.index'));
});


test('subcategories show return correct view', function () {

    $subcategory = Subcategory::factory()->make();

    allow_authorize('view', $subcategory);

    $response = app(SubcategoryController::class)->show($subcategory);

    expect($response)->toBeView('subcategories.show');

});

test('only authorized user can see subcategories show page', function () {


    $subcategory = Subcategory::factory()->make();

    authorize_check_by_policy('show subcategory', 'view', $subcategory);

});

test('categories edit return correct view', function () {

    $subcategory = Subcategory::factory()->make();

    allow_authorize('editSubcategory', $subcategory);

    $response = app(SubcategoryController::class)->edit($subcategory);

    expect($response)->toBeView('subcategories.edit');

});

test('only authorized user can see user edit page', function () {

    $subcategory = Subcategory::factory()->make();

    authorize_check_by_policy('edit subcategory', 'editSubcategory', $subcategory);

});


test('can update subcategory and return correct redirect', function () {


    /** @var Subcategory $old_subcategory */
    $old_subcategory = Subcategory::factory()->create([
        'name' => 'Test Name',
        'description' => 'Test Description',
    ]);

    allow_authorize('editSubcategory', $old_subcategory);

    $request = \Illuminate\Http\Request::create(route('subcategories.edit', $old_subcategory), 'PUT', [
        'name' => 'New Test Name',
        'description' => 'New Test Description',
    ]);

    $response = app(SubcategoryController::class)->update($request, $old_subcategory);

    /** @var Subcategory $subcategory */
    $subcategory = Subcategory::findOrFail(1);

    expect($subcategory->name)->toBe('New Test Name');
    expect($subcategory->description)->toBe('New Test Description');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('subcategories.show', $subcategory));

});


test('can delete subcategory and return correct redirect', function () {

    /** @var Subcategory $subcategory */
    $subcategory = Subcategory::factory()->create();

    allow_authorize('deleteSubcategory', $subcategory);

    $response = app(SubcategoryController::class)->destroy($subcategory);

    expect(Subcategory::count())->toBe(0);
    expect($response)->toBeRedirect(route('subcategories.index'));

});
