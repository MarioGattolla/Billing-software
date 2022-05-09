<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DB;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('showAny', Order::class);

        return view('orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('createOrder', Order::class);

        return \view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('createOrder', Order::class);

        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return View
     * @throws AuthorizationException
     */
    public function show(Order $order): View
    {
        $this->authorize('show', $order);

        return \view('orders.show', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Order $order): View
    {
        $this->authorize('editOrder', $order);

        return \view('orders.edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $this->authorize('editOrder', $order);

        return redirect()->route('orders.show', ['order' => $order]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Order $order): RedirectResponse
    {
        $this->authorize('deleteOrder', $order);

        return redirect()->route('orders.index');
    }

    public function search(Request $request): Response|Application|ResponseFactory
    {
        $products = DB::table('products')->where('name', 'like', "%" . $request->search . "%" )
            ->get(['id', 'name', 'description', 'price', 'vat']);

        return response($products);
    }
}
