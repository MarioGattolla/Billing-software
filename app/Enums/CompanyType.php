<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum CompanyType: string
{
    case private = 'private';
    case business = 'business';

    public static function get_cases_values(): array
    {
        return collect(CompanyType::cases())->map(fn(CompanyType $companyType) => $companyType->value)->toArray();
    }

}
