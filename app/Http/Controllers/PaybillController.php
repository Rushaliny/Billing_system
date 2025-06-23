<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paybill;



class PaybillController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_address' => 'required|string|max:255',
        'nic' => 'required|string|max:20',
        'mobile' => 'required|string|max:20',
        'service_type' => 'required|string',
        'account_number' => 'required|string|max:50',
        'district' => 'required|string|max:100',
        'bill_month' => 'required|date',
        'base_amount' => 'required|numeric',
        'additional_charges' => 'required|numeric',
        'total_amount' => 'required|numeric',
        'payment_status' => 'required|string',
        'payment_method' => 'required|string',
        'cancel_reason' => 'nullable|string',
    ]);

    Paybill::create($validated);

    return redirect()->back()->with('success', 'Bill submitted successfully.');
}
public function show()
{
    $paybills = Paybill::latest()->get();
    return view('show', compact('paybills'));
}

}
