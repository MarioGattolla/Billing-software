<?php

namespace App\Http\Controllers;

use App\Actions\Companies\CreateNewCompany;
use App\Actions\Companies\UpdateCompany;
use App\Actions\Orders\CreateNewOrder;
use App\Actions\Products\UpdateProduct;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use DefStudio\Actions\Exceptions\ActionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $this->authorize('viewAny', Order::class);

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
     * @param StoreOrderRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ActionException
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $this->authorize('createOrder', Order::class);

        $validated = $request->validated();

        if ($validated['company_id'] == null) {

            // NEW COMPANY -> SAVING DATA
            CreateNewCompany::run($validated);

        } else {

            // EXISTING COMPANY -> UPDATING DATA
            $company = Company::findOrFail($validated['company_id']);
            UpdateCompany::run($validated, $company);
        }



        CreateNewCompany::run($request->validated());


        // FOREACH PRODUCT SELECTED
        $count = 0;
        foreach ($validated['id'] as $id) {
            $product = Product::findOrFail($id);

            $validated_product = [
                'name' => $validated['name'][$count],
                'description' => $validated['description'][$count],
                'min_stock' => $product->min_stock,
                'weight' => $product->weight,
                'department' => $product->department,
                'category_id' => $product->category_id,
                'price' => $validated['price'][$count],
                'vat' => $validated['vat'][$count],
            ];

            // UPDATE PRODUCT
            UpdateProduct::run($validated_product, $product);

        }
        CreateNewOrder::run($validated);
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
        $this->authorize('view', $order);

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


}
