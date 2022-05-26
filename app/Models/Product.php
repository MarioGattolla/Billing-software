<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $description
 * @property int $min_stock
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereMinStock($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $name
 * @method static ProductFactory factory(...$parameters)
 * @method static Builder|Product whereName($value)
 * @property int $weight
 * @property string $department
 * @property int $category_id
 * @property int $price
 * @property int $vat
 * @property-read Category $category
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereDepartment($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereVat($value)
 * @method static Builder|Product whereWeight($value)
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'min_stock',
        'department',
        'category_id',
        'weight',
        'price',
        'vat',
    ];

    /** @return BelongsTo<Category, Product> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /** @return BelongsToMany<Order> */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->using(OrderProduct::class);
    }

    /** @return Attribute<int, float> */
    public function price(): Attribute
    {
        return Attribute::make(
            get: fn(int $price) => round($price / 100, 2),
            set: fn(float $price) => $this->attributes['price'] = floor($price * 100),
        );
    }

    /** @return Attribute<int,float> */
    public function vat_price(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->price * (100 + $this->vat) / 100
        );
    }

    public function available_stock()
    {
        return OrderProduct::whereProductId($this->id)->sum('quantity');

    }
}

