<?php

namespace App\Http\Controllers;

use App\Actions\Products\CreateNewProduct;
use App\Actions\Products\UpdateProduct;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use DefStudio\Actions\Exceptions\ActionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Product::class);

        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('createProduct', Product::class);

        $product = new  Product();
        return view('products.create', ['product' => $product]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return RedirectResponse
     * @throws ActionException
     * @throws AuthorizationException
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->authorize('createProduct', Product::class);

        $validated = $request->validated();

        CreateNewProduct::run($validated);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return View
     * @throws AuthorizationException
     */
    public function show(Product $product): View
    {
        $this->authorize('view', $product);

        return view('products.show', [
            'product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Product $product): View
    {
        $this->authorize('editProduct', $product);

        return view('products.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(StoreProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('editProduct', $product);

        $validated = $request->validated();

        UpdateProduct::run($validated, $product);

        return redirect()->route('products.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('deleteProduct', $product);

        $product->deleteOrFail();

        return redirect()->route('products.index');
    }
}
