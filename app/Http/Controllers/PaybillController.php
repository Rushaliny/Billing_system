<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paybill;



class PaybillController extends Controller
{



    public function store(Request $request)
{
    $validated = $request->validate([
        // 'customer_name' => 'required|string|max:255',
        // 'customer_address' => 'required|string|max:255',
        // 'nic' => 'required|string|max:20',
        'payee_account_number' => 'required|string|max:50',
        'mobile' => 'required|string|max:20',
        'service_type' => 'required|string',
        'account_number' => 'required|string|max:50',
        // 'district' => 'required|string|max:100',
        'bill_month' => 'required|date',
        'base_amount' => 'required|numeric',
        'additional_charges' => 'required|numeric',
        'total_amount' => 'required|numeric',
        'payment_status' => 'required|string',
        'payment_method' => 'required|string',
        'cancel_reason' => 'nullable|string',
        'payment_receipt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // max 2MB

    ]);

    // Save the file
    // if ($request->hasFile('payment_receipt')) {
    //     $filePath = $request->file('payment_receipt')->store('receipts', 'public');
    //     $validated['receipt_path'] = $filePath;
    // }


        // Save the file
    if ($request->hasFile('payment_receipt')) {
        $validated['receipt_path'] = $request->file('payment_receipt')->store('receipts', 'public');
    }

      // Handle file upload
    // $receiptPath = null;
    // if ($request->hasFile('payment_receipt')) {
    //     $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
    // }



    // Save to DB (assuming you have a `receipt_path` column)

    // Paybill::create($validated);

    // Save PayBill data
    PayBill::create([
        'receipt_path' => $receiptPath,
        // Add other fields here, example:
        'account_number' => $request->account_number,
        'payee_account_number' => $request->payee_account_number,
        'mobile' => $request->mobile,
        'service_type' => $request->service_type,
        'bill_month' => $request->bill_month,
        'base_amount' => $request->base_amount,
        'additional_charges' => $request->additional_charges,
        'total_amount' => $request->total_amount,
        'payment_status' => $request->payment_status,
        'payment_method' => $request->payment_method,
        'cancel_reason' => $request->cancel_reason,
    ]);


    return redirect()->back()->with('success', 'Payment submitted and receipt uploaded!');
}

public function show(Request $request)
{
    // Start the query builder from the PayBill model
    $paybillsQuery = PayBill::query();

    // If there's a search keyword, apply the filter
    if ($request->has('search') && $request->search != '') {
        $paybillsQuery->where('payee_account_number', 'like', '%' . $request->search . '%');
    }

    // Get the results
    $paybills = $paybillsQuery->latest()->get();

    // Load the correct Blade view
    return view('show', compact('paybills'));
}

}
