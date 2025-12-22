<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        if($user->role === 1){
            return redirect()->intended(route('admin.hotel.index'));
        }
        if($user->role === 2){
            return redirect()->intended(route('hotelAdmin.room_types.index'));
        }
        if($user->role === 0){
            return redirect()->intended(route('home'));
        }

        if ($user->role == 0 && $user->blocked) {
        Auth::logout(); // log them out immediately
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Your account has been blocked. Please contact support.']);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
