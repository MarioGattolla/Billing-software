<?php

namespace App\Http\Controllers;

use App\Actions\Companies\CreateNewCompany;
use App\Actions\Companies\UpdateCompany;
use App\Actions\Products\UpdateProduct;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use DB;
use DefStudio\Actions\Exceptions\ActionException;
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
     * @param StoreOrderRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ActionException
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $this->authorize('createOrder', Order::class);

        $validated = $request->validated(['company_business_name']);
        $business_name = $request['company_business_name'];
        $vat_number = $request['company_vat_number'];
        $country_select = $request['company_country'];
        $address = $request['company_address'];
        $email = $request['company_email'];
        $phone = $request['company_phone'];
        $contact_name = $request['private_name'];

        if ($request['company_id'] == null) {

            // NEW COMPANY -> SAVING DATA
            CreateNewCompany::run($business_name, $vat_number, $country_select, $address, $email, $phone, $contact_name);

        } else {

            // EXISTING COMPANY -> UPDATING DATA
            $company = Company::findOrFail($request['company_id']);
            UpdateCompany::run($business_name, $vat_number, $country_select, $address, $email, $phone, $contact_name, $company);
        }

        $count = 0;

        CreateNewCompany::run($request->validated());

        // FOREACH PRODUCT SELECTED
        foreach ($request['id'] as $id) {
            $product = Product::findOrFail($id);

            $name = $request['name'];
            $description = $request['description'];
            $min_stock = $product->min_stock;
            $weight = $product->weight;
            $department = $product->department;
            $category_id = $product->category_id;
            $price = $request['price'];
            $vat = $request['vat'];

            // UPDATE PRODUCT
            UpdateProduct::run($name, $description, $min_stock, $weight, $department, $category_id, $price, $vat, $product);

        }

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


}
