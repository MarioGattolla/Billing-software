<?php

namespace App\Http\Controllers;

use App\Actions\Companies\CreateNewCompany;
use App\Models\Company;
use DefStudio\Actions\Exceptions\ActionException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(): View
    {
        return view('companies.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Company::class);

        return view('companies.create', []);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     * @throws ActionException
     */
    public function store(Request $request): RedirectResponse
    {

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
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
