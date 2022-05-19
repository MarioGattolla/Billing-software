<?php

namespace App\Http\Controllers;

use App\Models\InvoiceRaw;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;

class InvoiceRawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('invoiceRaws.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return \view('invoiceRaws.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('invoiceRaws.index');
    }

    /**
     * Display the specified resource.
     *
     * @param InvoiceRaw $invoice_raw
     * @return View
     */
    public function show(InvoiceRaw $invoice_raw):View
    {
        return \view('invoiceRaws.show', ['invoice_raw' => $invoice_raw]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InvoiceRaw $invoice_raw
     * @return View
     */
    public function edit(InvoiceRaw $invoice_raw): View
    {
        return \view('invoiceRaws.edit', ['invoice_raw' => $invoice_raw]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param InvoiceRaw $invoice_raw
     * @return RedirectResponse
     */
    public function update(Request $request, InvoiceRaw $invoice_raw): RedirectResponse
    {
        return redirect()->route('invoiceRaws.show', ['invoice_raw' => $invoice_raw]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param InvoiceRaw $invoice_raw
     * @return RedirectResponse
     */
    public function destroy(InvoiceRaw $invoice_raw): RedirectResponse
    {
        return redirect()->route('invoiceRaws.index');
    }
}
