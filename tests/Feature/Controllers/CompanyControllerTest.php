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

    $translator = $this->createMock(Translator::class);
    $request = new StoreCompanyRequest();
    $validator = new Validator($translator,
        [
            'selectedRadioID' => 1,
            'contact_name' => 'Test',
            'business_name' => 'Test Name',
            'vat_number' => '123456789',
            'country_select' => 'Test',
            'address' => 'Test Address',
            'email' => 'email@test.it',
            'phone' => '392222222',

        ],
        $request->rules());


    $validated = $request->setValidator($validator);

    $response = app(CompanyController::class)->store($validated);

    /** @var User $user */
    $company = Company::findOrFail(1);

    expect($company->business_name)->toBe('Test Name');
    expect($company->contact_name)->toBe(null);
    expect($company->vat_number)->toBe('123456789');
    expect($company->country)->toBe('Test');
    expect($company->address)->toBe('Test Address');
    expect($company->email)->toBe('email@test.it');
    expect($company->phone)->toBe('392222222');
    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('companies.index'));
});

test('can store private and return correct redirect', function () {

    allow_authorize('createCompany', Company::class);

    $translator = $this->createMock(Translator::class);
    $request = new StoreCompanyRequest();
    $validator = new Validator($translator,
        [
            'selectedRadioID' => 2,
            'contact_name' => 'Test Name',
            'business_name' => 'Test Name',
            'vat_number' => '123456789',
            'country_select' => 'Test',
            'address' => 'Test Address',
            'email' => 'email@test.it',
            'phone' => '392222222',

        ],
        $request->rules());


    $validated = $request->setValidator($validator);

    $response = app(CompanyController::class)->store($validated);

    /** @var User $user */
    $company = Company::findOrFail(1);

    expect($company->business_name)->toBe(null);
    expect($company->contact_name)->toBe('Test Name');
    expect($company->vat_number)->toBe(null);
    expect($company->country)->toBe('Test');
    expect($company->address)->toBe('Test Address');
    expect($company->email)->toBe('email@test.it');
    expect($company->phone)->toBe('392222222');
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
    $old_company = Company::factory()->create([
        'business_name' => 'Test Name',
        'contact_name' => null,
        'email' => 'email@test.it',
        'phone' => '392222222',
        'vat_number' => '123456789',
        'address' => 'Address Test',
        'country' => 'Test',
    ]);

    allow_authorize('editCompany', $old_company);
    $translator = $this->createMock(Translator::class);
    $request = new StoreCompanyRequest();
    $validator = new Validator($translator,
        [
            'contact_name' => 'Test New Name',
            'business_name' => 'Test New Name',
            'vat_number' => '1234567891',
            'country' => 'New Test',
            'address' => 'New Address Test',
            'email' => 'newemail@test.it',
            'phone' => '3922222221',

        ],
        $request->rules());

    $validated = $request->setValidator($validator);

    $response = app(CompanyController::class)->update($validated, $old_company);

    /** @var Company $company */
    $company = Company::findOrFail(1);

    expect($company->contact_name)->toBe(null);
    expect($company->business_name)->toBe('Test New Name');
    expect($company->vat_number)->toBe('1234567891');
    expect($company->country)->toBe('New Test');
    expect($company->address)->toBe('New Address Test');
    expect($company->email)->toBe('newemail@test.it');
    expect($company->phone)->toBe('3922222221');
    expect($response)->toHaveStatus(302);
    expect($response)->toBeRedirect(route('companies.show', $company));

});

test('can update private and return correct redirect', function () {

    /** @var Company $old_private */
    $old_private = Company::factory()->create([
        'business_name' => null,
        'contact_name' => 'Test Name',
        'email' => 'email@test.it',
        'phone' => '392222222',
        'vat_number' => null,
        'address' => 'Address Test',
        'country' => 'Test',
    ]);

    allow_authorize('editCompany', $old_private);
    $translator = $this->createMock(Translator::class);
    $request = new StoreCompanyRequest();
    $validator = new Validator($translator,
        [
            'contact_name' => 'Test New Name',
            'business_name' => 'Test New Name',
            'vat_number' => '1234567891',
            'country' => 'New Test',
            'address' => 'New Address Test',
            'email' => 'newemail@test.it',
            'phone' => '3922222221',

        ],
        $request->rules());

    $validated = $request->setValidator($validator);

    $response = app(CompanyController::class)->update($validated, $old_private);

    /** @var Company $company */
    $company = Company::findOrFail(1);

    expect($company->contact_name)->toBe('Test New Name');
    expect($company->business_name)->toBe(null);
    expect($company->vat_number)->toBe(null);
    expect($company->country)->toBe('New Test');
    expect($company->address)->toBe('New Address Test');
    expect($company->email)->toBe('newemail@test.it');
    expect($company->phone)->toBe('3922222221');
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
