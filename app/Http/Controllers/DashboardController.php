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

        // // Total income (if "amount" includes additional charges)
        // $totalIncome = Paybill::sum('amount');

        // Count of pending and paid bills
        // $pendingPayments = Paybill::where('payment_status', 'Pending')->count();
        $paidPayments = Paybill::where('payment_status', 'Paid')->count();

        // Pass data to view
        return view('index', compact(
            'totalPaybills',
            // 'totalIncome',
            // 'pendingPayments',
            'paidPayments'
        ));
    }
}
