<?php

namespace App\Http\Controllers;

use App\Http\Requests\Billing\BillingRequest;
use App\Models\Billing;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Customer $customer)
    {
        $billings = $customer->billings()->with(['service', 'customer'])->filter($request->input())->paginate();

        return response()->json($billings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillingRequest $request, Customer $customer)
    {
        $billing = $customer->billings()->create($request->validated());

        return response()->json(new JsonResource($billing), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, Billing $billing)
    {
        $billing = $customer->billings()->findOrFail($billing->id);
        $billing->load(['service']);

        return response()->json(new JsonResource($billing));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillingRequest $request, Customer $customer, Billing $billing,)
    {
        $billing = $customer->billings()->findOrFail($billing->id);
        $billing->update($request->validated());

        return response()->json(new JsonResource($billing));
    }
}
