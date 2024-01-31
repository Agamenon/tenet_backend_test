<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\InvoiceHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerInvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Customer $customer)
    {
        return DB::transaction(function () use ($customer){
            $billings = $customer->billings()->lastFifteenDays()->get();
            $handler = new InvoiceHandler();
            $handler->addItems($billings);
            $detail = $handler->getInvoiceDetail();
            $amount = $handler->calculateTotalInvoice();

            return response()->json(['amount' => $amount, 'detail' => $detail]);
        });
    }
}
