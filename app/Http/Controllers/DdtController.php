<?php

namespace App\Http\Controllers;

use App\Models\Ddt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class DdtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('ddts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return \view('ddts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('ddts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Ddt $ddt
     * @return View
     */
    public function show(Ddt $ddt): View
    {
        return view('ddts.show', ['ddt' => $ddt]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ddt $ddt
     * @return View
     */
    public function edit(Ddt $ddt): View
    {
        return \view('ddts.edit', ['ddt' => $ddt]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ddt $ddt
     * @return RedirectResponse
     */
    public function update(Request $request, Ddt $ddt): RedirectResponse
    {
        return redirect()->route('ddts.show', ['ddt' => $ddt]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ddt $ddt
     * @return RedirectResponse
     */
    public function destroy(Ddt $ddt): RedirectResponse
    {
        return redirect()->route('ddts.index');
    }
}
