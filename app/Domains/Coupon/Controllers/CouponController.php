<?php

namespace App\Domains\Coupon\Controllers;

use App\Domains\Coupon\Requests\ValidateCouponRequest;
use App\Domains\Coupon\Requests\CreateCouponRequest;
use App\Domains\Coupon\Services\CouponService;
use App\Http\Controllers\Controller;


class CouponController extends Controller
{
    public $coupon_service;

    public function __construct(CouponService $coupon_service) 
    {
        $this->coupon_service = $coupon_service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCouponRequest $request)
    {
        $response = $this->coupon_service->createCoupon($request->validated());

        return response()->json($response, $response['response_code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidateCouponRequest $request)
    {
        $response = $this->coupon_service->validateCoupon($request->validated());

        return response()->json($response, $response['response_code']);
    }

}
