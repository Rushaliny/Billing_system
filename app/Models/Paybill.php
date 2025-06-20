<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paybill extends Model
{
    protected $fillable = [
        'customer_name', 'customer_address', 'nic', 'mobile', 'service_type',
        'account_number', 'district', 'bill_month', 'base_amount',
        'additional_charges', 'total_amount', 'payment_status',
        'payment_method', 'cancel_reason',
    ];

    public $timestamps = true; // Optional: only needed if you want to confirm it's using timestamps
}
