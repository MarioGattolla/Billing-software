<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SearchCompanyController extends Controller
{
    public function search_companies_privates(Request $request): AnonymousResourceCollection
    {
        $companies = Company::query()
            ->where('business_name', 'like', "%" . $request->search . "%")->orWhere('contact_name', 'like', "%" . $request->search . "%")
            ->get();

        return CompanyResource::collection($companies);
    }

    public function search_companies(Request $request): AnonymousResourceCollection
    {
        $companies = Company::query()
            ->where('business_name', 'like', "%" . $request->search . "%")
            ->get();

        return CompanyResource::collection($companies);
    }
}
