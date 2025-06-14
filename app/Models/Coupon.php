<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'amount',
        'percentage',
        'max_usage',
        'max_usage_user',
        'expiry_date'
    ];

    /**
     * The user that belong to the coupon.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function usedCoupons() : HasMany 
    {
        return $this->hasMany(UsedCoupon::class);    
    }

}
