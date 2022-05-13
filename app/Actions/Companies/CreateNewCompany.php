<?php

namespace App\Actions\Companies;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewCompany
{
    use ActsAsAction;

    public function handle($validated): void
    {
        $business_name = $validated->businessname;
        $contact_name = $validated->contact_name;
        $vat_number = $validated->vat_number;
        $country_select = $validated->country_select;
        $address = $validated->address;
        $email = $validated->email;
        $phone = $validated->phone;

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
