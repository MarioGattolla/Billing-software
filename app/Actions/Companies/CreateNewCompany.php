<?php

namespace App\Actions\Companies ;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewCompany
{
    use ActsAsAction;

    public function handle($business_name, $vat_number, $country_select, $address,
                           $email, $phone, $contact_name)
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
