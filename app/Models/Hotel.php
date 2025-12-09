<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'description',
        'email',
        'location',
        'social_links',
        'image',
        'user_id',
    ];
    protected $casts=[
        'social_links'=>'array',
    ];
    public function user(){
        return   $this->belongsTo(User::class);
    }
    public function rooms(){
        return $this->hasMany(Room::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    public function promocodes(){
        return $this->hasMany(PromoCode::class);
    }
}
