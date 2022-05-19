<?php

namespace App\Http\Controllers;

use App\Models\DdtRaw;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
class DdtRawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('ddtRaws.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return \view('ddtRaws.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('ddtRaws.index');
    }

    /**
     * Display the specified resource.
     *
     * @param DdtRaw $ddt_raw
     * @return View
     */
    public function show(DdtRaw $ddt_raw): View
    {
        return \view('ddtRaws.show', ['ddtRaw' => $ddt_raw]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DdtRaw $ddt_raw
     * @return View
     */
    public function edit(DdtRaw $ddt_raw): View
    {
        return \view('ddtRaws.edit', ['ddt_raw' => $ddt_raw]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DdtRaw $ddt_raw
     * @return RedirectResponse
     */
    public function update(Request $request, DdtRaw $ddt_raw): RedirectResponse
    {
        return redirect()->route('ddtRaws.show', ['ddt_raw' => $ddt_raw]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DdtRaw $ddt_raw
     * @return RedirectResponse
     */
    public function destroy(DdtRaw $ddt_raw): RedirectResponse
    {
        return redirect()->route('ddtRaws.index');
    }
}
