<?php

use App\Http\Controllers\CompanyController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('Admin can create new Company ', function () {

   $response = $this->actingAs(new User())->post('/companies',[
       'selectedRadioID' => 1,
       'business_name' => 'name',
       'vat_number' => '1245678',
       'country_select' => 'italy',
       'email' => 'test@email.it',
       'phone' => '399999999',
       'address' => 'road 23/a',
    ]);

   expect($response)->toHaveStatus(302)->assertRedirect();
});

test('Admin can create new Private ', function () {

    $response = $this->actingAs(new User())->post('/companies',[
        'selectedRadioID' => 2,
        'contact_name' => 'name',
        'country_select' => 'italy',
        'email' => 'test@email.it',
        'phone' => '399999999',
        'address' => 'road 23/a',
    ]);

    expect($response)->toHaveStatus(302)->assertRedirect();
});

test('Companies.store return redirect selecting Company', function (){

    actingAs(new User());

    $request = \Illuminate\Http\Request::create('/companies/create', 'POST', [
       'selectedRadioID' => 1,
        'business_name' => 'name',
        'vat_number' => '1245678',
        'country_select' => 'italy',
        'email' => 'test@email.it',
        'phone' => '399999999',
        'address' => 'road 23/a',
    ]);

    $response = app(CompanyController::class)->store($request);

    expect($response)->toBeRedirect(route('companies.index'));
});

test('Companies.store return redirect selecting Private', function (){

    actingAs(new User());

    $request = \Illuminate\Http\Request::create('/companies/create', 'POST', [
        'selectedRadioID' => 2,
        'contact_name' => 'name',
        'country_select' => 'italy',
        'email' => 'test@email.it',
        'phone' => '399999999',
        'address' => 'road 23/a',
    ]);

    $response = app(CompanyController::class)->store($request);

    expect($response)->toBeRedirect(route('companies.index'));
});
