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
        'start_date',
        'end_date',
        'is_active'
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }
    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }
}
