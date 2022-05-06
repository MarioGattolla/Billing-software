<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $progressive
 * @property Carbon $order_date
 * @property string $invoice_date
 * @property string $terms_conditions
 * @property int $total
 * @property string $type
 * @property-read Collection|InvoiceRaw[] $invoiceRaws
 * @property-read int|null $invoice_raws_count
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereInvoiceDate($value)
 * @method static Builder|Invoice whereOrderDate($value)
 * @method static Builder|Invoice whereProgressive($value)
 * @method static Builder|Invoice whereTermsConditions($value)
 * @method static Builder|Invoice whereTotal($value)
 * @method static Builder|Invoice whereType($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'progressive',
        'order_date',
        'invoice_date',
        'terms_conditions',
        'total',
        'type',
    ];

    protected $casts= [
        'order_date' => 'datetime:d-m-Y',
    ];

    /** @return BelongsToMany<Order> */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    /** @return HasMany<InvoiceRaw> */
    public function invoiceRaws(): HasMany
    {
        return $this->hasMany(InvoiceRaw::class, 'invoice_id', 'id');
    }
}
