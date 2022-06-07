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
        if ($this->type == 'private') {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'country' => $this->country,
                'address' => $this->address,
                'vat_number' => '',

            ];
        } else {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'vat_number' => $this->vat_number,
                'phone' => $this->phone,
                'country' => $this->country,
                'address' => $this->address,

            ];
        }

    }
}
