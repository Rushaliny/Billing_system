<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\Models\Paybill; // Use your actual model
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Show report index page
    public function index()
    {

        $serviceTypes = DB::table('paybills')->distinct()->pluck('service_type');
        return view('reports', compact('serviceTypes'));

        // return view('reports');
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

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        elseif ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('bill_month', $request->month)
                ->whereYear('bill_month', $request->year);


        }
       

        $paybills = $query->get();
        $serviceTypes = DB::table('paybills')->distinct()->pluck('service_type');


        return view('reports', compact('paybills','serviceTypes'));
    }

    public function download(Request $request)
    {
        $query = Paybill::query();

        // Filter by created_at date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        // // Filter by month and year on created_at
        // if ($request->filled('month') && $request->filled('year')) {
        //     $query->whereMonth('created_at', $request->month)
        //     ->whereYear('created_at', $request->year);
        // }

        // Filter by year only on created_at
        elseif ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

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
            fputcsv($file, ['Payee Account Number', 'Mobile', 'Service Type', 'Account No', 'Bill Month', 'Base Amount', 'Charges', 'Total', 'Status', 'Method', 'Cancel Reason', 'Date']);

            foreach ($paybills as $bill) {
                fputcsv($file, [
                    // $bill->customer_name,
                    $bill->payee_account_number,
                    $bill->mobile,
                    $bill->service_type,
                    $bill->account_number,
                    // $bill->district,
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
