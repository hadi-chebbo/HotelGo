<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;


    protected $fillable=[
        'type',
        'price_per_night',
        'status',
        'image',
        'hotel_id',
    ];
    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
