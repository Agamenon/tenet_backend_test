<?php

namespace App\Services;

use App\Enums\CurrencyTypeEnum;
use App\Enums\ServiceTypeEnum;
use App\Exceptions\InvoiceItemException;
use App\Models\Billing;
use App\Models\Service;
use App\Services\ItemsTypes\InvoiceItemI;
use Brick\Money\Money;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class InvoiceHandler{

    /**
     * Items
     *
     * @var array (InvoiceItemI)
     */
    protected $items = [];

    /**
     * Add a Item to Invoices
     *
     * @param Billing $item
     * @return void
     */
    public function addItem(Billing $item)
    {
        $this->items[] = $this->createInvoiceItem($item);
    }

    /**
     * Add Massive Items
     *
     * @param Collection $items
     * @return void
     */
    public function addItems(Collection $items){
       $items->each(fn($item)=> $this->addItem($item));
    }

    /**
     * Construct a Invoice Item
     *
     * @param Billing $billing
     * @return InvoiceItemI
     */
    protected function createInvoiceItem(Billing $billing) : InvoiceItemI{
        $billing_map = ServiceTypeEnum::asArray();

        if(in_array(Str::upper($billing->service->name), $billing_map)){
            throw new InvoiceItemException("Billing {$billing->service->name} couldn't processed");

        }
        $class = "App\Services\ItemsTypes\\"."{$billing->service->name}Item";

        return new $class($billing);
    }

    /**
     * Calculate Total Invoice Amount
     *
     * @return string
     */
    public function calculateTotalInvoice() : string {
        $amount = collect($this->items)->reduce(function (?string $carry, InvoiceItemI $item) {
            return Money::of($carry ?? 0, CurrencyTypeEnum::USDSMALL())->plus($item->calculateTotal())->getAmount();
        });

        return Money::of($amount ?? 0, CurrencyTypeEnum::USDSMALL())->getAmount();
    }


}