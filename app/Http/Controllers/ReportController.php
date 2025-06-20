<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    // Filter and return view with paybill results
    public function filter(Request $request)
    {
        $from = $request->input('from_date');
        $to = $request->input('to_date');
        $month = $request->input('month');
        $year = $request->input('year');

        $paybills = Paybill::query()
            ->when($from && $to, fn($q) => $q->whereBetween('paid_at', [$from, $to]))
            ->when($month, fn($q) => $q->whereMonth('paid_at', $month))
            ->when($year, fn($q) => $q->whereYear('paid_at', $year))
            ->orderBy('paid_at', 'desc')
            ->get();

        return view('reports', compact('paybills'));
    }

    // Download filtered report as CSV
    public function download(Request $request)
    {
        $from = $request->input('from_date');
        $to = $request->input('to_date');
        $month = $request->input('month');
        $year = $request->input('year');

        $paybills = Paybill::query()
            ->when($from && $to, fn($q) => $q->whereBetween('paid_at', [$from, $to]))
            ->when($month, fn($q) => $q->whereMonth('paid_at', $month))
            ->when($year, fn($q) => $q->whereYear('paid_at', $year))
            ->orderBy('paid_at', 'desc')
            ->get();

        $filename = "filtered_paybills.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($paybills) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Customer', 'Account Number', 'Bill Month', 'Units', 'Amount', 'Paid On']);

            foreach ($paybills as $bill) {
                fputcsv($handle, [
                    $bill->customer_name,
                    $bill->account_number,
                    Carbon::parse($bill->bill_month)->format('F Y'),
                    $bill->units_consumed,
                    $bill->amount,
                    Carbon::parse($bill->paid_at)->format('Y-m-d'),
                ]);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
