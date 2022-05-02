<?php

namespace App\Http\Controllers;

use App\Actions\Subcategories\CreateNewSubcategory;
use App\Actions\Subcategories\UpdateSubcategory;
use App\Models\Subcategory;
use Cassandra\Exception\ValidationException;
use DefStudio\Actions\Exceptions\ActionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;

class SubcategoryController extends Controller
{ /**
 * Display a listing of the resource.
 *
 * @return View
 * @throws AuthorizationException
 */
    public function index(): View
    {
        $this->authorize('viewAny', Subcategory::class);

        return \view('subcategories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('createSubcategory', Subcategory::class);

        return \view('subcategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ValidationException
     * @throws ActionException|\Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('createSubcategory', Subcategory::class);

        $this->validate($request, [
            'name' => 'required|string',
        ]);

        $name = $request->input('name');
        $description = $request->input('description');

        CreateNewSubcategory::run($name, $description);

        return redirect()->route('subcategories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Subcategory $subcategory
     * @return View
     * @throws AuthorizationException
     */
    public function show(Subcategory $subcategory): View
    {
        $this->authorize('view', $subcategory);

        return \view('subcategories.show', [
            'subcategory' => $subcategory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subcategory $subcategory
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Subcategory $subcategory): View
    {
        $this->authorize('editSubcategory', $subcategory);

        return \view('subcategories.edit', [
            'subcategory' => $subcategory,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Subcategory $subcategory
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ValidationException|ActionException|\Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Subcategory $subcategory): RedirectResponse
    {
        $this->authorize('editSubcategory', $subcategory);

        $this->validate($request, [
            'name' => 'required|string',
        ]);

        $name = $request->input('name');
        $description = $request->input('description');

        UpdateSubcategory::run($name, $description, $subcategory);

        return redirect()->route('subcategories.show', $subcategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subcategory $subcategory
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(Subcategory $subcategory): RedirectResponse
    {
        $this->authorize('deleteSubcategory', $subcategory);

        $subcategory->deleteOrFail();

        return redirect()->route('subcategories.index');
    }
}
