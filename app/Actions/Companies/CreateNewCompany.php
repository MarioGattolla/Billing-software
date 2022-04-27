<?php

namespace App\Actions\Companies ;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewCompany
{
    use ActsAsAction;

    public function handle(string $business_name,string $vat_number,string $country_select,string $address,
                           string $email,string $phone,string $contact_name): void
    {
        Company::create([
            'business_name' => $business_name,
            'contact_name' => $contact_name,
            'vat_number' => $vat_number,
            'country' => $country_select,
            'address' => $address,
            'email' => $email,
            'phone' => $phone,
        ])->save();
    }
}
