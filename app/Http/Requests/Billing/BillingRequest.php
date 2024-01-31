<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

class BillingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isStoring = $this->routeIs('billing.store');
        $fieldPresent = $isStoring ? 'required' : 'sometimes';

        return [
            "service_id" => [$fieldPresent,'exists:services,id'],
            "date" => [$fieldPresent,'date_format:Y-m-d'],
            "quantity" => [$fieldPresent,'integer']
        ];
    }
}
