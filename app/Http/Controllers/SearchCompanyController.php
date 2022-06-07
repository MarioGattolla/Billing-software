<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use PhpParser\Builder;

class SearchCompanyController extends Controller
{
    public function search_companies_privates(Request $request): AnonymousResourceCollection
    {
        $companies = Company::query()
            ->where('name', 'like', "%" . $request->search . "%")
            ->get();

        return CompanyResource::collection($companies);
    }

    public function search_companies(Request $request): AnonymousResourceCollection
    {
        $companies = Company::query()
            ->where('nanme', 'like', "%" . $request->search . "%")
            ->get();

        return CompanyResource::collection($companies);
    }

    public function search_company_with_orders(Request $request): AnonymousResourceCollection
    {
        $companies = Company::whereHas('orders', function ($query) use ($request) {
            $query->where('type', $request->type);
        })->where(function ($query) use ($request) {
            $query->where('name', 'like', "%" . $request->search . "%");
        })
            ->get();

        return CompanyResource::collection($companies);
    }
}
