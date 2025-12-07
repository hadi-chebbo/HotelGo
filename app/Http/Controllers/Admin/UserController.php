<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
      
    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->blocked = 1;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User has been blocked.'
        ]);
    }

   
    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->blocked = 0;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User has been unblocked.'
        ]);
    }
    public function index()
    {
        $users = User::all();
        return view('UserMgmt',compact($users));
    }

    public function update(Request $request, $id)
    {
        
        $user = User::findOrFail($id);

        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        
        $user->name = $request->name;
        $user->email = $request->email;  
        $user->phone = $request->phone;
       
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }
}  