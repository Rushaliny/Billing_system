<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paybill; // Make sure this model exists

class DashboardController extends Controller
{
    public function index()
    {
        // Total number of bills
        $totalPaybills = Paybill::count();

        // Only consider Paid bills
        $paidBills = Paybill::where('payment_status', 'Paid');

        // Sum total_amount and base_amount for only paid bills
        $sumTotalAmount = $paidBills->sum('total_amount');
        $sumBaseAmount = $paidBills->sum('base_amount');

        // Total income is the difference (additional charges)
        $totalIncome = $sumTotalAmount - $sumBaseAmount;

        // Count pending and paid bills
        $pendingPayments = Paybill::where('payment_status', 'Pending')->count();
        $paidPayments = $paidBills->count();

        return view('index', compact(
            'totalPaybills',
            'totalIncome',
            'pendingPayments',
            'paidPayments'
        ));
    }
}
