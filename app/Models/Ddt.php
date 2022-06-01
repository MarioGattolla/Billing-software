<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @property-read Collection|DdtRaw[] $ddtRaws
 * @property-read int|null $ddt_raws_count
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @method static Builder|Ddt newModelQuery()
 * @method static Builder|Ddt newQuery()
 * @method static Builder|Ddt query()
 * @method static Builder|Ddt whereCausal($value)
 * @method static Builder|Ddt whereCreatedAt($value)
 * @method static Builder|Ddt whereDate($value)
 * @method static Builder|Ddt whereId($value)
 * @method static Builder|Ddt whereProgressive($value)
 * @method static Builder|Ddt whereType($value)
 * @method static Builder|Ddt whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $year
 * @method static Builder|Ddt whereYear($value)
 */
class Ddt extends Model
{
    use HasFactory;

    protected $fillable = [
        'progressive',
        'date',
        'causal',
        'type',
        'year',
    ];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
    ];

    /** @return BelongsToMany<Order> */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    /** @return HasMany<DdtRaw> */
    public function ddtRaws(): HasMany
    {
        return $this->hasMany(DdtRaw::class, 'ddt_id', 'id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::saved(function (Ddt $ddt) {

            $ddt->year = Carbon::createFromFormat('d-m-Y', $ddt->date)->format('Y');
            $ddt->save();
        });
    }
}
