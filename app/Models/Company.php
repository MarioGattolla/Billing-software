<?php

namespace App\Models;

use Database\Factories\CompanyFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string|null $business_name
 * @property string|null $contact_name
 * @property string $country
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string|null $vat_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @method static Builder|Company whereAddress($value)
 * @method static Builder|Company whereBusinessName($value)
 * @method static Builder|Company whereContactName($value)
 * @method static Builder|Company whereCountry($value)
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereEmail($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company wherePhone($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company whereVatNumber($value)
 * @mixin Eloquent
 * @method static CompanyFactory factory(...$parameters)
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'contact_name',
        'country',
        'address',
        'email',
        'phone',
        'vat_number',
    ];

    /** @return HasMany<Order> */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
