<?php

namespace App\Http\Controllers;

use App\Actions\Products\CreateNewProduct;
use App\Actions\Products\UpdateProduct;
use App\Models\Product;
use DefStudio\Actions\Exceptions\ActionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
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

        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ValidationException
     * @throws ActionException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('createProduct', Product::class);

        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'min_stock' => 'required|integer',
        ]);

        $name = $request->input('name');
        $description = $request->input('description');
        $min_stock = $request->input('min_stock');

        CreateNewProduct::run($name, $description, $min_stock);

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
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     * @throws AuthorizationException|ValidationException
     * @throws ActionException
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorize('editProduct', $product);

        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'min_stock' => 'required|integer',
        ]);

        $name = $request->input('name');
        $description = $request->input('description');
        $min_stock = $request->input('min_stock');

        UpdateProduct::run($name, $description, $min_stock, $product);

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
