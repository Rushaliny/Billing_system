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

public function downloadCsv()
{
    $paybills = Paybill::all();
    $filename = 'paybills_' . now()->format('Ymd_His') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$filename",
    ];

    $callback = function () use ($paybills) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['Customer Name', 'NIC', 'Mobile', 'Service Type', 'Account No', 'District', 'Bill Month', 'Base', 'Charges', 'Total', 'Status', 'Method', 'Reason', 'Date']);

        foreach ($paybills as $bill) {
            fputcsv($file, [
                $bill->customer_name,
                $bill->nic,
                $bill->mobile,
                $bill->service_type,
                $bill->account_number,
                $bill->district,
                \Carbon\Carbon::parse($bill->bill_month)->format('F Y'),
                $bill->base_amount,
                $bill->additional_charges,
                $bill->total_amount,
                $bill->payment_status,
                $bill->payment_method,
                $bill->cancel_reason ?? '-',
                $bill->created_at->format('Y-m-d')
            ]);
        }

        fclose($file);
    };

    return Response::stream($callback, 200, $headers);
}

public function downloadPdf()
{
    $paybills = Paybill::all();
    $pdf = Pdf::loadView('reports.pdf', compact('paybills'));
    return $pdf->download('paybills_' . now()->format('Ymd_His') . '.pdf');
}


}
// Note: Ensure you have the necessary model and view files created for this controller to work properly.
