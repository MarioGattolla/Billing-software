<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\InvoiceRaw
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $invoice_id
 * @property int $vat
 * @property int $order_product_id
 * @property-read Invoice $invoice
 * @method static Builder|InvoiceRaw newModelQuery()
 * @method static Builder|InvoiceRaw newQuery()
 * @method static Builder|InvoiceRaw query()
 * @method static Builder|InvoiceRaw whereCreatedAt($value)
 * @method static Builder|InvoiceRaw whereId($value)
 * @method static Builder|InvoiceRaw whereInvoiceId($value)
 * @method static Builder|InvoiceRaw whereOrderProductId($value)
 * @method static Builder|InvoiceRaw whereUpdatedAt($value)
 * @method static Builder|InvoiceRaw whereVat($value)
 * @mixin Eloquent
 */
class InvoiceRaw extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'vat',
        'order_product_id',
    ];

    /** @return BelongsTo<Invoice, InvoiceRaw> */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }


}
