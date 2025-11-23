<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'reserrvation_id',
        'amount',
        'method',
        'status',
        'transaction_date',
    ];
}
