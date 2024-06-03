<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('success', 'Inicio de sesión exitoso');
        } else {
            $error = 'Usuario incorrecto';
            return view('login', compact('error'));
        }
    }

    public function registro(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('success', 'Registro exitoso');
        } else {
            $error = 'Usuario incorrecto';
            return view('login', compact('error'));
        }
    }
}
