<?php

namespace App\Actions\Companies;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateCompany
{
    use ActsAsAction;

    public function handle(mixed $validated, Company $company): bool
    {

        if ($company->contact_name == null) {
            $validated['contact_name'] = null;
        } // Request is a Private
        else {
            $validated['business_name'] = null;
            $validated['vat_number'] = null;
        }

        $company->update([
            'business_name' => $validated['business_name'],
            'contact_name' => $validated['contact_name'],
            'vat_number' => $validated['vat_number'],
            'country' => $validated['country'],
            'address' => $validated['address'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        return $company->save();
    }
}
