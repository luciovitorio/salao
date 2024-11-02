<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Auth::user()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }
}
