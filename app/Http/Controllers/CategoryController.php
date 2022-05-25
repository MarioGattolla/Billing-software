<?php

namespace App\Http\Controllers;

use App\Actions\Categories\CreateNewCategory;
use App\Actions\Categories\UpdateCategory;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use DefStudio\Actions\Exceptions\ActionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Category::class);

        return \view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('createCategory', Category::class);

        $category = Category::factory()->make(['parent_id' => null]);

        return \view('categories.create' , ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return RedirectResponse
     * @throws ActionException
     * @throws AuthorizationException
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {

       $this->authorize('createCategory', Category::class);

        $validated = $request->validated();

        $parent_id = $validated['parent_id'];
        $name = $validated['name'];
        $description = $validated['description'];

        CreateNewCategory::run($name, $description, $parent_id);

        return redirect()->route('categories.index')->with('success', 'Category created !!');
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return View
     * @throws AuthorizationException
     */
    public function show(Category $category): View
    {
        $this->authorize('view', $category);

        return \view('categories.show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Category $category): View
    {
        $this->authorize('editCategory', $category);

        return \view('categories.edit', [
            'category' => $category,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     * @throws ActionException
     * @throws AuthorizationException
     */
    public function update(StoreCategoryRequest $request, Category $category): RedirectResponse
    {

        $this->authorize('editCategory', $category);

        $validated = $request->validated();

        $parent_id = $validated['parent_id'];
        $name = $validated['name'];
        $description = $validated['description'];

        UpdateCategory::run($name, $description, $parent_id , $category);

        return redirect()->route('categories.show', $category)->with('success', 'Category updated !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('deleteCategory', $category);

        $category->deleteOrFail();

        return redirect()->route('categories.index')->with('success', 'Category deleted !!');
    }
}
