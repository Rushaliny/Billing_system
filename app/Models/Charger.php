<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Charger extends Model
{
        use HasFactory;

    //
    protected $fillable = ['applicable_to', 'amount'];

}
