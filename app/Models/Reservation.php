<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'room_id',
        'promo_code_id',
        'check_in_date',
        'check_out_date',
        'total_price',
        'status'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function promocode(){
        return $this->hasOne(PromoCode::class);
    }
    public function payment(){
        return $this->hasMany(Payment::class);
    }

}
