<?php

namespace App\Models;

use Database\Factories\OrderProductFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;



/**
 * App\Models\OrderProduct
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $order_id
 * @property int|null $product_id
 * @property int $price
 * @property int $vat
 * @property int $quantity
 * @method static \Database\Factories\OrderProductFactory factory(...$parameters)
 * @method static Builder|OrderProduct newModelQuery()
 * @method static Builder|OrderProduct newQuery()
 * @method static Builder|OrderProduct query()
 * @method static Builder|OrderProduct whereCreatedAt($value)
 * @method static Builder|OrderProduct whereId($value)
 * @method static Builder|OrderProduct whereOrderId($value)
 * @method static Builder|OrderProduct wherePrice($value)
 * @method static Builder|OrderProduct whereProductId($value)
 * @method static Builder|OrderProduct whereQuantity($value)
 * @method static Builder|OrderProduct whereUpdatedAt($value)
 * @method static Builder|OrderProduct whereVat($value)
 * @mixin \Eloquent
 */
class OrderProduct extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    public $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'vat',
    ];

    public function vat(): Attribute
    {
        return Attribute::make(
            get: fn(int $vat) => round($vat/100, 2),
            set: fn(float $vat) => $this->attributes['vat'] = floor($vat*100),
        );
    }

    public function total(): Attribute
    {
        return Attribute::make(
            get: fn(int $price) => round($price/100, 2),
            set: fn(float $price) => $this->attributes['price'] = floor($price*100),
        );
    }
}


