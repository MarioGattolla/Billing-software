<?php

namespace App\Enums;

enum OrderType: string
{
    case incoming = 'incoming';
    case outcoming = 'outcoming';


    public static function get_cases_values(): array
    {
        return collect(OrderType::cases())->map(fn(OrderType $orderType) => $orderType->value)->toArray();
    }
}
