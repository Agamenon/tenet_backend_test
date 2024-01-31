<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing>
 */
class BillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "customer_id" => Customer::factory(),
            "service_id" => Service::factory(),
            "date" => now()->toDateString(),
            "quantity" => fake()->randomNumber(1,10)
        ];
    }
}
