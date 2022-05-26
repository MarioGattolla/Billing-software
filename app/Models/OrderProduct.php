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


    /**
     * @return Attribute<int , float>
     */
    public function price(): Attribute
    {
        return Attribute::make(
            get: fn(int $price) => round($price / 100, 2),
            set: fn(float $price) => $this->attributes['price'] = floor($price * 100),
        );
    }


    public function total(): float|int
    {
        $total_ex_vat = $this->price * $this->quantity;
        $vat_total = ($total_ex_vat * $this->vat) / 100;
        return round($vat_total + $total_ex_vat, 2);
    }

    public function total_ex_vat(): float|int
    {
        return round($this->price * $this->quantity, 2);
    }

    public function quantity(): Attribute
    {
        return Attribute::make(
            get: fn(int $quantity) => $quantity < 0 ? $quantity * -1 : $quantity,

    );
    }
}


