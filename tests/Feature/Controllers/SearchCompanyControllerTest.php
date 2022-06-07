<?php

use App\Http\Controllers\SearchCompanyController;
use App\Models\Company;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can search business only', function () {

    Company::factory()->count(10)->create(['type' => 'private', 'name' => 'test']);


    $company = Company::factory()->count(5)->create(['name' => 'test']);


    $request = Request::create('/search/company/companies', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(SearchCompanyController::class)->search_companies($request);


    expect($response->count())->toBe(5);

});


it('can search all companies', function () {

    Company::factory()->count(10)->create(['name' => 'Fail']);

    $company = Company::factory()->count(5)->create(['name' => 'test']);

    $request = Request::create('/search/company/all', 'GET', [
        'search' => 'tes',
    ]);

    $response = app(SearchCompanyController::class)->search_companies_privates($request);

    expect($response->count())->toBe(5);

});

it('search company with orders', function (string $type) {

    Company::factory()->count(3)->create(['name' => 'test']);
    Company::factory()->count(10)->create();

    Company::findMany([1, 3])
        ->each(fn(Company $company) => $company->orders()->create(['type' => $type, 'date' => today()]));

    Company::find(2)->orders()->create(['type' => 'prova', 'date' => today()]);

    $request = Request::create('/search/company_with_orders', 'GET', [
        'search' => 'test',
        'type' => $type,
    ]);

    $response = app(SearchCompanyController::class)->search_company_with_orders($request);

    expect($response->count())->toBe(2);
})->with([
    'ingoing' => [
        'type' => 'ingoing',
    ],
    'outgoing' => [
        'type' => 'outgoing',
    ]
]);
