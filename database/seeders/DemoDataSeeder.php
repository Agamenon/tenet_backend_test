<?php

namespace Database\Seeders;

use App\Enums\ServiceTypeEnum;
use App\Models\Billing;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all();
        $customers = Customer::factory()->count(3)->create();
        $customers->each(function($customer) use ($services){
            $services->each(function($service) use ($customer){
                if($service->name !== ServiceTypeEnum::BACKOFFICE){
                    Billing::factory()
                            ->for($customer)
                            ->for($service)
                            ->count(5)
                            ->sequence(fn (Sequence $sequence) => ['date' => now()->subDays(fake()->randomNumber(1, 14))->toDateString()])
                            ->create(["quantity" => fake()->randomNumber(1, 10)]);
                }
                Billing::factory()
                        ->for($customer)
                        ->for($service)
                        ->create(["quantity" => 1, "date" => now()->subDays(fake()->randomNumber(1, 14))->toDateString()]);
            });
        });
    }
}
