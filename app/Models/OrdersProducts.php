<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrdersProducts
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $order_id
 * @property int|null $product_id
 * @property int $price_ex_vat
 * @property int $total
 * @property int $quantity
 * @property int $company_id
 * @method static Builder|OrdersProducts newModelQuery()
 * @method static Builder|OrdersProducts newQuery()
 * @method static Builder|OrdersProducts query()
 * @method static Builder|OrdersProducts whereCompanyId($value)
 * @method static Builder|OrdersProducts whereCreatedAt($value)
 * @method static Builder|OrdersProducts whereId($value)
 * @method static Builder|OrdersProducts whereOrderId($value)
 * @method static Builder|OrdersProducts wherePriceExVat($value)
 * @method static Builder|OrdersProducts whereProductId($value)
 * @method static Builder|OrdersProducts whereQuantity($value)
 * @method static Builder|OrdersProducts whereTotal($value)
 * @method static Builder|OrdersProducts whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\OrdersProductsFactory factory(...$parameters)
 */
class OrdersProducts extends Model
{
    use HasFactory;

    public $incrementing = true;

    public $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'total',
        'price_ex_vat',
    ];
}
