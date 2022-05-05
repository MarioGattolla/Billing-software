<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Ddt
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $progressive
 * @property \Illuminate\Support\Carbon $date
 * @property string $causal
 * @property string $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DdtRaw[] $ddtRaws
 * @property-read int|null $ddt_raws_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt whereCausal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt whereProgressive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ddt whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ddt extends Model
{
    use HasFactory;

    protected $fillable = [
        'progressive',
        'date',
        'causal',
        'type',
    ];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function ddtRaws(): HasMany
    {
        return $this->hasMany(DdtRaw::class, 'ddt_id', 'id');
    }
}
