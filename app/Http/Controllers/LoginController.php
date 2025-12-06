<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required', 'max:255', 'min:4'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found');
        }

        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Invalid credentials');
        }

        if ($user->role === "S") {
            return to_route('dashboard');
        } else {
            return to_route('home');
        }
    }
}
