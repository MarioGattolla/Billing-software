<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SearchOrderController extends Controller
{
    public function search_orders_by_company(Request $request): AnonymousResourceCollection
    {

        $orders = Order::whereHas('company', function ($query) use ($request) {
            $query->where('id', $request->company_id);
        })->get();

        return OrderResource::collection($orders);
    }
}
