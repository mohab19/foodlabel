<?php

namespace App\Domains\Coupon\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code'           => 'required|alpha_num:ascii|unique:coupons,code',
            'amount'         => 'required|numeric|min:1',
            'percentage'     => 'required|boolean',
            'max_usage'      => 'required|numeric|min:1',
            'max_usage_user' => 'numeric|min:1',
            'expiry_date'    => 'date_format:Y-m-d|after:today',
            'user_ids'       => 'array',
            'user_ids.*'     => 'exists:users,id'
        ];
    }
}
