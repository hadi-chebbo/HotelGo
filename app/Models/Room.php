<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;


    protected $fillable=[
        'hotel_id',
        'room_type_id',
        'room_number',
        'floor',
        'status'
    ];
    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function roomType(){
        return $this->belongsTo(RoomType::class);
    }
    public function room(){
        return $this->hasMany(Reservation::class);
    }
}
