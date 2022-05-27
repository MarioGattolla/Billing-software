<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\Types\Collection;
use function _PHPStan_7bd9fb728\React\Promise\all;
use function Pest\Laravel\get;

class SearchProductController extends Controller
{
    public function search_products(Request $request): AnonymousResourceCollection
    {
        $products = Product::query()
            ->where('name', 'like', "%" . $request->search . "%")
            ->get();

        return ProductResource::collection($products);
    }

    public function search_products_with_available_stock(Request $request): AnonymousResourceCollection
    {
        $products = Product::query()
            ->leftJoin('order_product', fn(JoinClause $join) => $join->on('products.id', '=', 'order_product.product_id'))
            ->where('name', 'like', "%" . $request->search . "%")
            ->groupBy('order_product.quantity')
            ->havingRaw('SUM(order_product.quantity) > 0')
            ->get();

        return ProductResource::collection($products);
    }

    public function search_products_by_company(Request $request): AnonymousResourceCollection|Response
    {
        $orders_id = Order::where('company_id', '=', $request->id)
            ->get()->map(fn(Order $order) => $order->id);
        if ($orders_id->count() == 0) {
            return response(null);
        } else {
            $products_id = OrderProduct::where('order_id', '=', $orders_id)
                ->get()->map(fn(OrderProduct $movement) => $movement->product_id);

            /** @var Product[] $products */
            $products = Product::where('name', 'like', "%" . $request->search . "%")
                ->findMany($products_id)->all();

            return ProductResource::collection($products);
        }
    }

}
