<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Actions\Companies\CreateNewCompany;
use App\Actions\Companies\CreateNewProduct;
use App\Actions\Companies\UpdateCompany;
use App\Actions\Companies\UpdateProduct;
use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use DefStudio\Actions\Exceptions\ActionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Company::class);

        return view('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('createCompany', Company::class);

        return view('companies.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyRequest $request
     * @return RedirectResponse
     * @throws ActionException
     * @throws AuthorizationException
     */
    public function store(StoreCompanyRequest $request): RedirectResponse
    {

        $this->authorize('createCompany', Company::class);

        // Request is a Company
        if ($request->validated()->selectedRadioID == 1) {
            $request->validated()->contact_name = null;
        } // Request is a Private
        else {
            $request->validated()->business_name = null;
            $request->validated()->vat_number = null;
        }

        CreateNewCompany::run($request->validated());

        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return View
     * @throws AuthorizationException
     */
    public function show(Company $company): View
    {
        $this->authorize('view', $company);

        return \view('companies.show', [
            'company' => $company,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Company $company): View
    {
        $this->authorize('editCompany', $company);

        return \view('companies.edit', [
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCompanyRequest $request
     * @param Company $company
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(StoreCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('editCompany', $company);

        dd($company);
        if ($company->contact_name == null) {
            $request->validated()->contact_name = null;
        } // Request is a Private
        else {
            $request->validated()->business_name = null;
            $request->validated()->vat_number = null;
        }

        return redirect()->route('companies.show', $company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('deleteCompany', $company);

        $company->deleteOrFail();

        return redirect()->route('companies.index');
    }
}
