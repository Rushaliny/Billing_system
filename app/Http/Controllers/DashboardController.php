<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paybill; // Make sure this model exists
use Illuminate\Support\Facades\DB;

use App\Models\User; // Assuming you have a User model
use Carbon\Carbon; // For date manipulation




class DashboardController extends Controller
{
    public function index()
    {


    $totalIncome = Paybill::where('payment_status', 'Paid')
    ->sum(DB::raw('total_amount - base_amount'));
    $totalPaybills = Paybill::count();
    $paidPayments = Paybill::where('payment_status', 'Paid')->sum('total_amount');
    $pendingPayments = Paybill::where('payment_status', 'Pending')->sum('total_amount');
    $cancelPayments = Paybill::where('payment_status', 'Cancelled')->sum('total_amount');

    // Monthly user stats
    $userStats = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $months = [];
    $totals = [];
    foreach ($userStats as $stat) {
        $months[] = Carbon::create()->month($stat->month)->format('F');
        $totals[] = $stat->total;
    }

    $paybills = Paybill::latest()->take(5)->get(); // fetch latest 5 records

    $paid = Paybill::where('payment_status', 'Paid')->count();
    $pending = Paybill::where('payment_status', 'Pending')->count();
    $cancelled = Paybill::where('payment_status', 'Cancelled')->count();


return view('index', compact(
    'totalIncome',
    'totalPaybills',
    'paidPayments',
    'pendingPayments',
    'cancelPayments',
    'paybills', 'paid', 'pending', 'cancelled',
    'months',
    'totals'

));

    }

 public function getMonthlyIncome()
{
    $monthlyIncome = DB::table('paybills')
        ->selectRaw("MONTHNAME(created_at) as month, SUM(total_amount - base_amount) as income")
        ->where('service_type', 'CEB')
        ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("MONTHNAME(created_at)"))
        ->orderBy(DB::raw("MONTH(created_at)"))
        ->pluck('income', 'month'); 

    return response()->json($monthlyIncome);
}


public function getWaterIncome()
{
    $monthlyIncome = DB::table('paybills')
        ->selectRaw("MONTHNAME(created_at) as month, SUM(total_amount - base_amount) as income")
        ->where('service_type', 'Water')
        ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("MONTHNAME(created_at)"))
        ->orderBy(DB::raw("MONTH(created_at)"))
        ->pluck('income', 'month');

    return response()->json($monthlyIncome);
}





}
