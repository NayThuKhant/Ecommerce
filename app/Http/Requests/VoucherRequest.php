<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'code' => 'required|min:6|max:15|unique:vouchers',
            'start_from' => 'required|date|after_or_equal:today',
            'end_at' => 'required|date|after:start_from',
            'type' => ['required', Rule::in(['money', 'percentage'])],
            'value' => 'required|numeric|min:1',
            'min_order_val' => 'required|numeric|min:0',
            'initial_voucher_count' => 'sometimes|required|numeric|min:1',
            'voucher_count' => 'sometimes|required|numeric|min:0',
            'is_active' => 'required|boolean'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'min_order_val' => 'Min. Order Value',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
