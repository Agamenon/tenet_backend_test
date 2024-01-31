<?php

namespace App\Services\ItemsTypes;

interface InvoiceItemI {

    public function calculateTotal() : string;
}