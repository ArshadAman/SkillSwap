<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (request()->isMethod('post')) {
            $data = request()->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
            if (Auth::attempt($data)) {
                $request->session()->regenerate();
                return redirect('');
            }
        }

        return view('login');
    }

    public function register(Request $request)
    {
        if ($request->isMethod(('post'))) {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'contact_info' => 'required|string|max:255',
            ]);
            $user = User::create($data);
            if ($user) {
                return redirect()->route('login');
            } else {
                return redirect()->route('register');
            }
        }

        return view('register');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
