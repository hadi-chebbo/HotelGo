<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    /** @use HasFactory<\Database\Factories\RoomTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'type',
        'description',
        'capacity',
        'price_per_night',
        'image',
    ];
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
