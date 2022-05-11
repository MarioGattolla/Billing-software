<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Company
 */
class CompanyResource extends JsonResource
{

    public function toArray($request): array
    {
        if ($this->business_name == null) {
            return [
                'id' => $this->id,
                'contact_name' => $this->contact_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'country' => $this->country,
                'address' => $this->address,
                'business_name' => '',
                'vat_number' => '',

            ];
        } else {
            return [
                'id' => $this->id,
                'business_name' => $this->business_name,
                'contact_name' => '',

                'email' => $this->email,
                'vat_number' => $this->vat_number,
                'phone' => $this->phone,
                'country' => $this->country,
                'address' => $this->address,

            ];
        }

    }
}
