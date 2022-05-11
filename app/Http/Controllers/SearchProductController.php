<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\OrdersProducts;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SearchProductController extends Controller
{
    public function search_products(Request $request): AnonymousResourceCollection
    {
        $products = Product::query()
            ->where('name', 'like', "%" . $request->search . "%")
            ->get();

        return ProductResource::collection($products);
    }

    public function search_products_by_company(Request $request): AnonymousResourceCollection
    {

        $movements = OrdersProducts::where('company_id', '==', $request->id)->get('id');

        $products = Product::findMany($movements)->all();

        return ProductResource::collection($products);
    }
}
