<?php

namespace App\Http\Requests\Billing;

use App\Enums\ServiceTypeEnum;
use App\Models\Service;
use Carbon\Carbon;
use Closure;
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
        $date  = $this->input("date");
        $billing = $this->route("billing") ?? null;
        $customer  = $this->route("customer") ?? null;

        return [
            "service_id" => [$fieldPresent,'exists:services,id', function (string $attribute, mixed $value, Closure $fail) use  ($date,$fieldPresent,$billing,$customer) {
                    $service = Service::where('name', ServiceTypeEnum::BACKOFFICE)->firstOrFail();

                    if($service->id !== $value){
                        return;
                    }

                    // If user not change date but change service
                    if(!$date && $fieldPresent == 'sometimes'){
                        $date = $billing->date->toDateString();
                    }

                    $start = Carbon::parse($date)->startOfMonth()->toDateString();
                    $end =   Carbon::parse($date)->endOfMonth()->toDateString();

                    if ($customer->billings()->whereBetween("date",[$start,$end])->count()) {
                        $fail("The {$attribute} is invalid, because you can only have one BackOffice Service per Month.");
                    }
            }],
            "date" => [$fieldPresent,'date_format:Y-m-d',"before_or_equal:today"],
            "quantity" => [$fieldPresent,'integer']
        ];
    }
}
