<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paybill extends Model
{
    protected $fillable = [
        'service_type','payee_account_number', 'mobile', 'account_number', 'bill_month', 'base_amount',
        'additional_charges', 'total_amount', 'payment_status',
        'payment_method', 'cancel_reason', 'receipt_path',
    ];

    public $timestamps = true; // Optional: only needed if you want to confirm it's using timestamps
}
