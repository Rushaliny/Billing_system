<?php

use Illuminate\Database\Seeder;
use App\Models\Paybill;
use Carbon\Carbon;

class PaybillSeeder extends Seeder
{
    public function run()
    {
        Paybill::insert([
            [
                'customer_name' => 'John Doe',
                'account_number' => 'ACC001',
                'bill_month' => '2025-01-01',
                'units_consumed' => 150,
                'amount' => 4500.00,
                'paid_at' => '2025-01-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_name' => 'Jane Smith',
                'account_number' => 'ACC002',
                'bill_month' => '2024-12-01',
                'units_consumed' => 200,
                'amount' => 6000.00,
                'paid_at' => '2024-12-28',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

