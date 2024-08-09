<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'insulin_hour'      => ['numeric', 'nullable', 'date_format:' . config('app.hour_format')],
            'insulin_id'        => ['integer', 'exists:App\Models\Insulin,id'],
            'quantity'          => ['required', 'numeric'],
            'product_log_date'  => ['required', 'date', 'date_format:' . config('app.date_format')],
            'product_log_hour'  => ['numeric', 'nullable'],
            'product_id'        => ['integer', 'exists:App\Models\Product,id'],
            'grams'             => ['required', 'numeric', 'min:1'],
            'carbohydrates'     => ['numeric', 'nullable'],
            'proteins'          => ['numeric', 'nullable'],
            'fats'              => ['numeric', 'nullable'],
            'comment'           => ['string', 'nullable'],
            'sugar_before_hour' => ['numeric', 'nullable'],
            'sugar_before'      => ['required', 'numeric'],
            'sugar_after_hour'  => ['numeric', 'nullable'],
            'sugar_after'       => ['required', 'numeric'],
        ];
    }
}
