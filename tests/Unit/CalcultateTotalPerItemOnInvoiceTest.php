<?php

namespace Tests\Unit;

use App\Enums\ServiceTypeEnum;
use App\Exceptions\InvoiceItemException;
use App\Models\Billing;
use App\Models\Service;
use App\Services\InvoiceHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalcultateTotalPerItemOnInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_calculate_total_per_item_on_invoice(): void
    {
        $backoffice = Service::where('name',ServiceTypeEnum::BACKOFFICE)->firstOrFail();
        $storage =    Service::where('name', ServiceTypeEnum::STORAGE)->firstOrFail();
        $proxy =    Service::where('name', ServiceTypeEnum::PROXY)->firstOrFail();
        $translate =    Service::where('name', ServiceTypeEnum::TRANSLATION)->firstOrFail();

        $itemBackoffice = Billing::factory(['quantity' => 1])->for($backoffice)->create();
        $itemStorages = Billing::factory(['quantity' => 1])->count(5)->for($storage)->create();
        $itemProxy = Billing::factory(['quantity' => 40])->count(2)->for($proxy)->create();
        $itemTranslation = Billing::factory(['quantity' => 5000])->count(4)->for($translate)->create();

        $handler = new InvoiceHandler();
        $handler->addItem($itemBackoffice);
        $handler->addItems($itemStorages);
        $handler->addItems($itemProxy);
        $handler->addItems($itemTranslation);

       $this->assertEquals("20092.21012", $handler->calculateTotalInvoice());
    }

    /**
     * A basic unit test example.
     */
    public function test_calculate_total_per_item_on_invoice_error(): void
    {
        $this->markTestSkipped();
        $backoffice = Service::factory(['name' => fake()->name()])->create();

        $itemBackoffice = Billing::factory(['quantity' => 1])->for($backoffice)->create();

        $handler = new InvoiceHandler();
        $this->expectException(InvoiceItemException::class);
        $handler->addItem($itemBackoffice);
    }
}
