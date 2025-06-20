<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paybill;
use Illuminate\Support\Carbon;

class PaybillSeeder extends Seeder
{
    public function run(): void
    {
        $months = ['2024-03', '2024-04', '2024-05'];

        foreach ($months as $month) {
            $billDate = $month . '-01'; // Ensure valid DATE format

            Paybill::create([
                'customer_name' => 'John Doe',
                'account_number' => 'ACC' . rand(1000, 9999),
                'bill_month' => $billDate,
                'units_consumed' => rand(50, 150),
                'amount' => 5000 + rand(10, 100), // Admin Paid
                'paid_at' => Carbon::parse($billDate)->addDays(rand(1, 10)),
            ]);

            Paybill::create([
                'customer_name' => 'Jane Smith',
                'account_number' => 'ACC' . rand(1000, 9999),
                'bill_month' => $billDate,
                'units_consumed' => rand(60, 120),
                'amount' => 5000 + rand(20, 80),
                'paid_at' => Carbon::parse($billDate)->addDays(rand(1, 10)),
            ]);
        }
    }
}
