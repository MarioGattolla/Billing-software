<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\DdtRaw
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $ddt_id
 * @property int $order_product_id
 * @property-read \App\Models\Ddt $ddt
 * @method static \Illuminate\Database\Eloquent\Builder|DdtRaw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DdtRaw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DdtRaw query()
 * @method static \Illuminate\Database\Eloquent\Builder|DdtRaw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DdtRaw whereDdtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DdtRaw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DdtRaw whereOrderProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DdtRaw whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DdtRaw extends Model
{
    use HasFactory;

    protected $fillable = [
        'ddt_id',
        'order_product_id',
    ];

    /** @return BelongsTo<Ddt , DdtRaw> */
    public function ddt(): BelongsTo
    {
        return $this->belongsTo(Ddt::class, 'ddt_id');
    }
}
