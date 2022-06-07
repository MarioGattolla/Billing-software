<?php

use App\Http\Controllers\CompanyController;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

uses(RefreshDatabase::class);


test('companies index return correct view', function () {

    allow_authorize('viewAny', Company::class);

    $response = app(CompanyController::class)->index();

    expect($response)->toBeView('companies.index');

});

test('only authorized user can see index page', function () {

    authorize_check_by_policy('show company', 'viewAny', Company::class);

});

test('companies create return correct view', function () {

    allow_authorize('createCompany', Company::class);

    $response = app(CompanyController::class)->create();

    expect($response)->toBeView('companies.create');

});

test('only authorized user can see create page', function () {

    authorize_check_by_policy('create company', 'createCompany', Company::class);

});

test('can store company and return correct redirect', function () {

    allow_authorize('createCompany', Company::class);

    $validated = create_validated_request(newBusinessData(), StoreCompanyRequest::class);

    $response = app(CompanyController::class)->store($validated);

    /** @var User $user */
    $company = Company::findOrFail(1);

    expect($company->name)->toBe('Test Name');
    expect($company->vat_number)->toBe('123456789');
    expect($company->country)->toBe('Test');
    expect($company->address)->toBe('Test Address');
    expect($company->email)->toBe('email@test.it');
    expect($company->phone)->toBe('392222222');
    expect($company->type)->toBe('private');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('companies.index'));
});

test('can store private and return correct redirect', function () {

    allow_authorize('createCompany', Company::class);

    $validated = create_validated_request(newPrivateData(), StoreCompanyRequest::class);

    $response = app(CompanyController::class)->store($validated);

    /** @var User $user */
    $company = Company::findOrFail(1);

    expect($company->name)->toBe('Test Name');
    expect($company->vat_number)->toBe(null);
    expect($company->country)->toBe('Test');
    expect($company->address)->toBe('Test Address');
    expect($company->email)->toBe('email@test.it');
    expect($company->phone)->toBe('392222222');
    expect($company->type)->toBe('private');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('companies.index'));
});

test('companies show return correct view', function () {

    $company = Company::factory()->make();

    allow_authorize('view', $company);

    $response = app(CompanyController::class)->show($company);

    expect($response)->toBeView('companies.show');

});

test('only authorized user can see companies show page', function () {


    $company = Company::factory()->make();

    authorize_check_by_policy('show company', 'view', $company);

});

test('companies edit return correct view', function () {

    $company = Company::factory()->make();

    allow_authorize('editCompany', $company);

    $response = app(CompanyController::class)->edit($company);

    expect($response)->toBeView('companies.edit');

});

test('only authorized user can see user edit page', function () {

    $company = Company::factory()->make();

    authorize_check_by_policy('edit company', 'editCompany', $company);

});


test('can update company and return correct redirect', function () {

    /** @var Company $old_company */
    $old_company = Company::factory()->for_business()->create();

    allow_authorize('editCompany', $old_company);

    $validated = create_validated_request(newBusinessData(), StoreCompanyRequest::class);

    $response = app(CompanyController::class)->update($validated, $old_company);

    /** @var Company $company */
    $company = Company::findOrFail(1);


    expect($company->name)->toBe('Test Name');
    expect($company->vat_number)->toBe('123456789');
    expect($company->country)->toBe('Test');
    expect($company->address)->toBe('Test Address');
    expect($company->email)->toBe('email@test.it');
    expect($company->phone)->toBe('392222222');
    expect($company->type)->toBe('business');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('companies.show', $company));

});

test('can update private and return correct redirect', function () {

    /** @var Company $old_private */
    $old_private = Company::factory()->for_private()->create();

    allow_authorize('editCompany', $old_private);

    $validated = create_validated_request(newPrivateData(), StoreCompanyRequest::class);

    $response = app(CompanyController::class)->update($validated, $old_private);

    /** @var Company $company */
    $company = Company::findOrFail(1);

    expect($company->name)->toBe('Test Name');
    expect($company->vat_number)->toBe(null);
    expect($company->country)->toBe('Test');
    expect($company->address)->toBe('Test Address');
    expect($company->email)->toBe('email@test.it');
    expect($company->phone)->toBe('392222222');
    expect($company->type)->toBe('private');

    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('companies.show', $company));

});


test('can delete company and return correct redirect', function () {

    /** @var Company $company */
    $company = Company::factory()->create();

    allow_authorize('deleteCompany', $company);

    $response = app(CompanyController::class)->destroy($company);

    expect(Company::count())->toBe(0);
    expect($response)->toBeRedirect(route('companies.index'));

});
