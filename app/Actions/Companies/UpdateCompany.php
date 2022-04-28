<?php

namespace App\Actions\Companies;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

class UpdateCompany
{
    use ActsAsAction;

    public function handle(mixed $business_name,mixed $vat_number,string $country_select,string $address,
                           string $email,string $phone,mixed $contact_name, Company $company): bool
    {
        $old_company = Company::findOrFail($company->id);

        $old_company->update([
            'business_name' => $business_name,
            'contact_name' => $contact_name,
            'vat_number' => $vat_number,
            'country' => $country_select,
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
        ]);

      return  $old_company->save();
    }
}
