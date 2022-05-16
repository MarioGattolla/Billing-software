<?php

namespace App\Actions\Companies;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewCompany
{
    use ActsAsAction;

    public function handle($validated): void
    {

        Company::create([
            'business_name' => $validated['business_name'],
            'contact_name' => $validated['contact_name'],
            'vat_number' => $validated['vat_number'],
            'country' => $validated['country'],
            'address' => $validated['address'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ])->save();
    }
}
