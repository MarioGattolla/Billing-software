<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Actions\Companies\CreateNewCompany;
use App\Actions\Companies\CreateNewProduct;
use App\Actions\Companies\UpdateCompany;
use App\Actions\Companies\UpdateProduct;
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
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws ActionException|AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {

        $this->authorize('createCompany', Company::class);

        // Request is a Company
        if ($request->selectedRadioID == 1) {
            $this->validate($request, [
                'business_name' => 'required',
                'vat_number' => 'required',
                'country_select' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ]);

            $request->contact_name = null;

        }

        // Request is a Private
        else {
            $this->validate($request, [
                'contact_name' => 'required',
                'country_select' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required'

            ]);

            $request->business_name = null;
            $request->vat_number = null;

        }

        $business_name = $request->business_name;
        $contact_name = $request->contact_name;
        $vat_number = $request->vat_number;
        $country_select = $request->country_select;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;

        CreateNewCompany::run($business_name, $vat_number, $country_select, $address,
            $email, $phone, $contact_name);

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
     * @param Request $request
     * @param Company $company
     * @return RedirectResponse
     * @throws AuthorizationException|ActionException
     * @throws ValidationException
     */
    public function update(Request $request, Company $company): RedirectResponse
    {
        $this->authorize('editCompany', $company);

        if ($company->vat_number == null){
            $this->validate($request, [
                'contact_name' => 'required',
                'country_select' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required'

            ]);

            $contact_name = $request->contact_name;
            $business_name = null;
            $vat_number = null;
        }
        else{
            $this->validate($request, [
                'business_name' => 'required',
                'vat_number' => 'required',
                'country_select' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ]);


            $business_name = $request->business_name;
            $vat_number = $request->vat_number;
            $contact_name = null;
        }


        $country_select = $request->country_select;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;

        UpdateCompany::run($business_name, $vat_number, $country_select, $address,
            $email, $phone, $contact_name, $company);

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
