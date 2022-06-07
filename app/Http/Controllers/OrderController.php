<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers;

use App\Actions\Companies\UpdateCompany;
use App\Actions\OrderProduct\CreateNewOrderProduct;
use App\Actions\Products\UpdateProduct;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

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
    public function old_create(): View
    {
        $this->authorize('createOrder', Order::class);

        return view('orders.old-create');
    }

    public function create(): View
    {
        $this->authorize('createOrder', Order::class);

        return view('orders.create');
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $this->authorize('createOrder', Order::class);

        $validated = $request->validated();

        $company_data = collect($validated['company'])->toArray();

        $company = $company_data['company_id']
            ? UpdateCompany::run($company_data)
            : Company::create($company_data);

        /** @var Order $order */
        $order = $company->orders()->create($validated);

        collect($request->validated('products'))
            ->each(fn(array $product_data) => UpdateProduct::run($product_data, Product::findOrFail($product_data['id'])))
            ->each(fn(array $product_data) => CreateNewOrderProduct::run($product_data, $order->id));

        return redirect()->route('orders.index')->with('success', 'Order created !!');
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
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        $this->authorize('editOrder', $order);

        $validated = $request->validated();

        $company_data = collect($request->validated('company'))->toArray();

        UpdateCompany::run($company_data);

        $order->update($validated);

        return redirect()->route('orders.show', ['order' => $order])->with('success', 'Order updated !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(Order $order): RedirectResponse
    {
        $this->authorize('deleteOrder', $order);


        $order->deleteOrFail();

        return redirect()->route('orders.index')->with('success', 'Order deleted !!');
    }


}
