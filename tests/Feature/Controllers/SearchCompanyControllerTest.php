<?php

use App\Http\Controllers\SearchCompanyController;
use App\Models\Company;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can search business only', function () {

    Company::factory()->count(10)->create(['contact_name' => 'test', 'business_name' => null]);


    $company = Company::factory()->count(5)->create(['business_name' => 'test']);


    $request = Request::create('/search/company/companies', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(SearchCompanyController::class)->search_companies($request);


    expect($response->count())->toBe(5);

});


it('can search all companies', function () {

    Company::factory()->count(10)->create(['business_name' => 'Fail']);

    $company = Company::factory()->count(5)->create(['business_name' => 'test']);

    $request = Request::create('/search/company/all', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(SearchCompanyController::class)->search_companies_privates($request);

    expect($response->count())->toBe(5);

});
