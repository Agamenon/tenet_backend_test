<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\ServiceTypeEnum;
use App\Models\Billing;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use App\Services\InvoiceHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CustomerInvoiceControllerTest extends TestCase
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
    public function test_generate_customer_invoice(): void
    {
        $backoffice = Service::where('name', ServiceTypeEnum::BACKOFFICE)->firstOrFail();
        $storage =    Service::where('name', ServiceTypeEnum::STORAGE)->firstOrFail();
        $proxy =    Service::where('name', ServiceTypeEnum::PROXY)->firstOrFail();
        $translate =    Service::where('name', ServiceTypeEnum::TRANSLATION)->firstOrFail();

        $customer = Customer::factory()->create();
        $customer->billings()->create(Billing::factory(['quantity' => 1, 'service_id' => $backoffice->id])->make()->toArray());
        $customer->billings()->createMany(Billing::factory(['quantity' => 1, 'service_id' => $storage->id])->count(5)->make()->toArray());
        $customer->billings()->createMany(Billing::factory(['quantity' => 40, 'service_id' => $proxy->id])->count(2)->make()->toArray());
        $customer->billings()->createMany(Billing::factory(['quantity' => 5000,'service_id' => $translate->id])->count(4)->make()->toArray());

        $handler = new InvoiceHandler();
        $handler->addItems($customer->billings()->lastFifteenDays()->get());

        $response = $this->getJson(route("customer.invoice", $customer->id));

        $response->assertSuccessful()->assertJson(
                fn (AssertableJson $json) => $json->where('amount', $handler->calculateTotalInvoice())
                    ->count("detail",4)
                    ->count("detail.BackOffice", 1)
                    ->count("detail.Storage", 5)
                    ->count("detail.Proxy", 2)
                    ->count("detail.Translation", 4)
                    ->etc()
            );
    }
}
