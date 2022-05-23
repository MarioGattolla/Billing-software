<?php /** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers;

use App\Actions\Companies\CreateNewCompany;
use App\Actions\Companies\UpdateCompany;
use App\Actions\OrderProduct\CreateNewOrderProduct;
use App\Actions\Products\UpdateProduct;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use DefStudio\Actions\Exceptions\ActionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function create(): View
    {
        $this->authorize('createOrder', Order::class);

        return view('orders.create');
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $this->authorize('createOrder', Order::class);

        $validated = $request->validated();

        $company = $validated['company_id']
            ? UpdateCompany::run($validated)
            : Company::create($validated);

        /** @var Order $order */
        $order = $company->orders()->create($validated);

        collect($request->validated('products'))
            ->each(fn(array $product_data) => UpdateProduct::run($product_data))
            ->each(fn(array $product_data) => $order->products()->syncWithPivotValues($product_data['id'], $product_data));

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
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ActionException
     */
    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        $this->authorize('editOrder', $order);

        $company = Company::findOrFail($order->company_id);
        $validated = $request->validated();

        UpdateCompany::run($validated, $company);

        UpdateOrder::run($validated, $order);

        return redirect()->route('orders.show', ['order' => $order]);
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

        return redirect()->route('orders.index');
    }


}
