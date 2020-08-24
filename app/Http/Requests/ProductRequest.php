<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'name' => ['required','min:5','max:255', Rule::unique('products')->ignore($this->id)],
            'highlight' => 'nullable|string',
            'description' => 'required|min:10',
            'included' => 'string',
            'featured_photo' => 'nullable|string|max:255',
            'variants' => function ($attribute, $value, $fail) {
                $variant_groups = collect(json_decode($value, true));
                if ($variant_groups->duplicates('SKU')->isNotEmpty())
                {
                    $fail("SKU must not duplicate.");
                }
                if ($variant_groups->isEmpty())
                {
                    $fail("Variant Group must not empty.");
                }
                foreach ($variant_groups as $variant_group)
                {
                    $vaildator = Validator::make($variant_group, [
                        'name' => 'required|string|max:255',
                        'color_family' => 'required|string',
                        'photos' => 'string',
                        "SKU" => 'required',
                        'stocks' => 'required|integer|min:0',
                        'is_available' => 'required|boolean',
                        'sale_price' => 'required|numeric|min:1',
                        'special_price' => 'required|numeric|min:0',
                        'shipping_fee_multiplier' => 'required|integer|min:0',
                    ], $this->messages(), $this->attributes());

                    if ($vaildator->fails())
                    {
                        $fail($vaildator->errors()->all());
                    }
                }
            }
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
            'SKU' => 'SKU'
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
