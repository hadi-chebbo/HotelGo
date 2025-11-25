<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelController extends Controller
{
    public function store(Request $request){
        $validated = $request -> validate([
            'name' => 'required|string|max:25',
            'description'=> 'string',
            'email' => 'required|email|max:100',
            'location' => 'required|string',
            'social_links' => 'required',
            'image' => 'image',
            'admin_phone' => 'required|string|max:10',
        ]);

        $admin = User::create([
            'name' => $validated['name'] . "Admin",
            'email'=> $validated['name'] . " Admin@" . $validated['name'] . ".com",
            'password' => bcrypt($validated['name'] . "hotelGopassword"),
            'phone' => $validated['admin_phone'],
            'role' => 2,
            
        ]);
        $hotel=$admin->hotel()->create($validated);

        
    }
}
