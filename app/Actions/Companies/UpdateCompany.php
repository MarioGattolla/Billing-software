<?php

namespace App\Actions\Companies;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateCompany
{
    use ActsAsAction;

    public function handle(mixed $validated, Company $company): bool
    {
        $old_company = Company::findOrFail($company->id);

        $business_name = $validated['business_name'];
        $contact_name = $validated['contact_name'];
        $vat_number = $validated['vat_number'];
        $country_select = $validated['country_select'];
        $address = $validated['address'];
        $email = $validated['email'];
        $phone = $validated['phone'];

        $old_company->update([
            'business_name' => $business_name,
            'contact_name' => $contact_name,
            'vat_number' => $vat_number,
            'country' => $country_select,
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
        ]);

        return $old_company->save();
    }
}
