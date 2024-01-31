<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Billing;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BillingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    /**
     * A basic feature test example.
     */
    public function test_billing_list(): void
    {
        $customer = Customer::factory()->create();

        Billing::factory()->for($customer)->count(10)->create();

        $this->getJson(route("billing.index",["customer" => $customer->id]))->assertSuccessful()->assertJsonCount(10,"data");
    }

    /**
     * A basic feature test example.
     */
    public function test_billing_list_with_filter(): void
    {
        $customer = Customer::factory()->create();
        $service = Service::factory()->create();
        Billing::factory()->for($service)->for($customer)->create(['date' => "2024-01-31", "quantity" => 10]);
        Billing::factory()->hasService()->for($customer)->create(['date' => "2024-01-31", "quantity" => 15]);

        $this->getJson(route("billing.index", ['customer'=>$customer->id,'quantity' => 10]))->assertSuccessful()->assertJsonCount(1, "data");
        $this->getJson(route("billing.index", ['customer' => $customer->id, 'service_id' => $service->id]))->assertSuccessful()->assertJsonCount(1, "data");
        $this->getJson(route("billing.index", ['customer' => $customer->id, 'date' => "2024-01-31"]))->assertSuccessful()->assertJsonCount(2, "data");
        $this->getJson(route("billing.index", ['customer' => $customer->id, 'date' => "2024-01-30"]))->assertSuccessful()->assertJsonCount(0, "data");
    }

    /**
     * A basic feature test example.
     */
    public function test_billing_create(): void
    {
        $customer = Customer::factory()->create();
        $billing = Billing::factory(['customer_id' => $customer->id])->make();

        $response = $this->postJson(route("billing.store", ["customer" => $customer->id]), $billing->toArray());

        $response->assertCreated()->assertJson(
            fn (AssertableJson $json) => $json->where('service_id', $billing->service_id)
                ->where("date", $billing->date->toDateString())
                ->where("quantity", $billing->quantity)
                ->etc()
        );
    }

    public static function billingErrorProvider()
    {
        return [
            "empty service" => [["service_id" => null, "date" => now()->toDateString(), "quantity" => fake()->randomNumber(1,9)], "service_id"],
            "wrong date" => [["service_id" => null, "date" => "31-01-2024", "quantity" => fake()->randomNumber(1, 9)], "date"],
            "empty quantity" => [["service_id" => null, "date" => "31-01-2024", "quantity" => null], "quantity"],
        ];
    }

    /**
     * @dataProvider billingErrorProvider
     */
    public function test_billing_create_errors($input,$valid): void
    {
        $customer = Customer::factory()->create();
        $response = $this->postJson(route("billing.store", ["customer" => $customer->id]), $input);

        $response->assertInvalid(["{$valid}"]);
    }

    /**
     * A basic feature test example.
     */
    public function test_billing_update(): void
    {
        $customer = Customer::factory()->create();
        $billing = Billing::factory()->for($customer)->create();
        $quantity = 10;

        $response = $this->putJson(route("billing.update", ["customer" => $customer->id, "billing"=>$billing->id]), ['quantity' => $quantity]);

        $response->assertSuccessful()->assertJson(
            fn (AssertableJson $json) => $json->where('quantity', $quantity)
                ->etc()
        );
    }

    /**
     * A basic feature test example.
     */
    public function test_customer_show(): void
    {
        $customer = Customer::factory()->create();
        $billing = Billing::factory()->for($customer)->create();

        $response = $this->getJson(route("billing.show", ["customer" => $customer->id, "billing" => $billing->id]));

        $response->assertSuccessful()->assertJson(
            fn (AssertableJson $json) => $json->where('service_id', $billing->service_id)
                ->where("date", $billing->date->toDateString())
                ->where("quantity", $billing->quantity)
                ->etc()
        );
    }
}
