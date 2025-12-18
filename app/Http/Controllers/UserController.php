<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
use App\Mail\AccountBlockedMail;
use App\Mail\AccountUnblockedMail;
use App\Models\User;
    use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

    class UserController extends Controller
    {
        //
        
        public function block(User $user)
        {
            $user->blocked = 1;
            $user->save();

            Mail::to($user->email)->send(new AccountBlockedMail($user));
            return redirect()->back()->with('success', $user->name . ' has been blocked.');
        }

    
        public function unblock(User $user)
        {
            $user->blocked = 0;
            $user->save();

            Mail::to($user->email)->send(new AccountUnblockedMail($user));
            return redirect()->back()->with('success', $user->name . ' has been unblocked.');
        }

        public function index()
        {
            $users = User::where('role', 0)->get();
            return view('systemAdmin.users.index',compact('users'));
        }

        public function update(Request $request, User $user)
        {

            $validated=$request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
            ]);

            
            $user->update($validated);

            return redirect()->back()->with('success', 'User updated successfully!');
        }
    }  