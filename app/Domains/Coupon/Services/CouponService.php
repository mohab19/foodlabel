<?php

namespace App\Domains\Coupon\Services;

use App\Domains\Coupon\Repositories\CouponRepository;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    public $coupon_repository;

    public function __construct(CouponRepository $coupon_repository) 
    {
        $this->coupon_repository = $coupon_repository;
    }

    public function createCoupon($request) : array 
    {
        $coupon = $this->coupon_repository->save($request);

        if($coupon) {
            if(isset($request['user_ids'])) {
                $attached = $this->coupon_repository->attachUsers($coupon, $request['user_ids']);
                if($attached !== true) {
                    $coupon->delete();
                    return [
                        'response_code'    => 400,
                        'response_message' => 'Coupon registration faild !',
                        'response_data'    => []
                    ];
                }
            }

            return [
                'response_code'    => 201,
                'response_message' => 'Coupon registrated successfully !',
                'response_data'    => $coupon
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'Coupon registration faild !',
            'response_data'    => []
        ];
    }

    private function isCouponInvalid($coupon, $user): bool
    {
        return (
            ($coupon->expiry_date && $coupon->expiry_date < date('Y-m-d')) ||
            ($coupon->users && !in_array($user->id, $coupon->users->pluck('id')->toArray())) ||
            ($coupon->usedCoupons && $coupon->usedCoupons()->sum('count') >= $coupon->max_usage) ||
            ($coupon->max_usage_user && optional($coupon->usedCoupons()->where('user_id', $user->id)->first())->count >= $coupon->max_usage_user)
        );
    }

    public function validateCoupon($request) : array 
    {
        $user   = Auth::guard('sanctum')->user(); 
        $coupon = $this->coupon_repository->getByCode($request['code']);

        if ($this->isCouponInvalid($coupon, $user)) {
            return [
                'response_code'    => 400,
                'response_message' => 'This Coupon is not valid !',
                'response_data'    => []
            ];
        }

        $recorded = $this->coupon_repository->update($user->id, $coupon->id);

        if($coupon->percentage) {
            $discount = intval($request['price']) * ($coupon->amount / 100);
        }
        else
            $discount = $coupon->amount;


        return [
            'response_code'    => 200,
            'response_message' => 'Coupon discount applied',
            'response_data'    => [
                'price'    => $request['price'],
                'discount' => $discount,
                'result'   => $request['price'] - $discount
            ]
        ];
    }

}
