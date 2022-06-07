<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum CompanyType: string
{
    case private = 'private';
    case business = 'business';

}
