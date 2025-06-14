<?php

namespace App\Domains\Coupon\Repositories;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\UsedCoupon;

class CouponRepository
{
    public $model;
    public $coupon_user_model;
    public $used_coupon_model;

    public function __construct(Coupon $coupon, CouponUser $coupon_user, UsedCoupon $used_coupon) 
    {
        $this->model             = $coupon;
        $this->coupon_user_model = $coupon_user;
        $this->used_coupon_model = $used_coupon;
    }

    public function save($request) : object 
    {
        return $this->model->create([
            'code'           => $request['code'],
            'amount'         => $request['amount'],
            'percentage'     => $request['percentage'],
            'max_usage'      => $request['max_usage'],
            'max_usage_user' => $request['max_usage_user'] ?? null,
            'expiry_date'    => $request['expiry_date'] ?? null
        ]);    
    }

    public function attachUsers($coupon, $user_ids) : bool 
    {
        try {
            $coupon->users()->sync($user_ids);
            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getByCode($code) : object 
    {
        return $this->model->where('code', $code)->first();
    }

    public function update($user_id, $coupon_id) : object 
    {
        $record = $this->used_coupon_model->where('user_id', $user_id)
                                          ->where('coupon_id', $coupon_id)
                                          ->first();
        if($record) {
            $record->increment('count');
            return $record;
        }
        else {
            return $this->used_coupon_model->create([
                'user_id'   => $user_id,
                'coupon_id' => $coupon_id,
                'count'     => 1
            ]);
        }
    }

}
