<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
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
    public function test_customer_list(): void
    {
        Customer::factory()->count(10)->create();

        $response = $this->getJson(route("customer.index"));

        $response->assertSuccessful()->assertJsonCount(10, 'data');
    }

    /**
     * A basic feature test example.
     */
    public function test_customer_create(): void
    {
        $customer = Customer::factory()->make();

        $response = $this->postJson(route("customer.store"), $customer->toArray());

        $response->assertSuccessful()->assertJson(
                fn (AssertableJson $json) => $json->where('name', $customer->name)
                    ->etc()
            );
    }

    public static function customerErrorProvider(){
        return [
            "null name" => [null],
            "empty name" => [""],
            "to large name" => [fake()->text(1000)]
        ];
    }

    /**
     * @dataProvider customerErrorProvider
     */
    public function test_customer_create_errors($input): void
    {
        $response = $this->postJson(route("customer.store"), ["name" => $input]);

        $response->assertInvalid(['name']);
    }


    /**
     * A basic feature test example.
     */
    public function test_customer_update(): void
    {
        $customer = Customer::factory()->create();
        $name = fake()->name();

        $response = $this->putJson(route("customer.update", $customer->id), ['name' => $name]);

        $response->assertSuccessful()->assertJson(
            fn (AssertableJson $json) => $json->where('name', $name)
                ->etc()
        );
    }

    /**
     * A basic feature test example.
     */
    public function test_customer_show(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->getJson(route("customer.show", $customer->id));

        $response->assertSuccessful()->assertJson(
            fn (AssertableJson $json) => $json->where('name', $customer->name)
                ->etc()
        );
    }


    /**
     * A basic feature test example.
     */
    public function test_customer_delete(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->getJson(route("customer.destroy", $customer->id));

        $response->assertSuccessful();
    }
}
