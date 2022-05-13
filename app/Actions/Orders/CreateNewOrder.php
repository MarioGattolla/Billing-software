<?php

namespace App\Actions\Orders ;

use App\Models\Company;
use DefStudio\Actions\Concerns\ActsAsAction;

class CreateNewOrder
{
    use ActsAsAction;

    public function handle(mixed $business_name,mixed $vat_number,string $country_select,string $address,
                           string $email,string $phone,mixed $contact_name): void
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
