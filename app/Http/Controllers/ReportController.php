<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Models\Paybill; // Use your actual model

class ReportController extends Controller
{
    // Show report index page
    public function index()
    {
        return view('reports');
    }

  public function filter(Request $request)
{
    $query = Paybill::query();

        // Filter by created_at date range
     if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }
     // Filter by year (created_at)
    if ($request->filled('year')) {
        $query->whereYear('created_at', $request->year);
    }

    elseif ($request->filled('month') && $request->filled('year')) {
        $query->whereMonth('bill_month', $request->month)
              ->whereYear('bill_month', $request->year);


    }
    //  elseif ($request->filled('year')) {
    //     $query->whereYear('bill_month', $request->year);
    // }

    $paybills = $query->get();

    return view('reports', compact('paybills'));
}

public function download(Request $request)
{
    $query = Paybill::query();

     // Filter by created_at date range
    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }
    // Filter by year (created_at)
    if ($request->filled('year')) {
        $query->whereYear('created_at', $request->year);
    }

    elseif ($request->filled('month') && $request->filled('year')) {
        $query->whereMonth('bill_month', $request->month)
              ->whereYear('bill_month', $request->year);
    }

    // elseif ($request->filled('year')) {
    //     $query->whereYear('bill_month', $request->year);
    // }

    $paybills = $query->get();

    $pdf = Pdf::loadView('reports.invoice', compact('paybills'));
    return $pdf->download('paybill_report.pdf');
}

}
// Note: Ensure you have the necessary model and view files created for this controller to work properly.
