<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $type
 * @property int|null $discount
 * @property Carbon $date
 * @property-read Collection|Ddt[] $ddts
 * @property-read int|null $ddts_count
 * @property-read Collection|Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereCompaniesId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDate($value)
 * @method static Builder|Order whereDiscount($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereType($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read Company|null $company
 * @method static OrderFactory factory(...$parameters)
 * @property int|null $company_id
 * @method static Builder|Order whereCompanyId($value)
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'company_id',
        'discount',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];


    /** @return BelongsToMany<Product> */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->using(OrderProduct::class);
    }

    /** @return BelongsToMany<Invoice> */
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class);
    }

    /** @return BelongsToMany<Ddt> */
    public function ddts(): BelongsToMany
    {
        return $this->belongsToMany(Ddt::class);
    }

    /** @return BelongsTo<Company, Order> */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
