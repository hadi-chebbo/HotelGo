<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id',
        'code',
        'discount_percentage',
        'usage_limit',
        'start_date',
        'end_date'
    ];
}
