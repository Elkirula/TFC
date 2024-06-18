<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Categorias;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all categories from the database
        $categorias = Categorias::all();

        // Get the email and password from the request
        $credentials = $request->only('email', 'password');
        
        // Check if the 'remember me' option was selected
        $remember = $request->filled('remember');

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt($credentials, $request->remember)) {
            // Redirect to the home route with a success message if authentication is successful
            return redirect()->route('home')->with('success', 'Successful login');
        } else {
            // Set an error message if authentication fails
            $error = 'Incorrect user';

            // Return to the login view with the error message and categories
            return view('login', compact('error', 'categorias'));
        }
    }

    public function registro(Request $request)
    {
        // // Validate the registration form data
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        //     'rol' => 'required|string'
        // ]);

        // Create a new user instance
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('rol');
        $user->foto = '';
        $user->save();
        
        // Log the user in
        Auth::login($user);

        // Redirect to the home page with a success message
        return redirect()->route('home')->with('success', 'Registration successful. Please verify your email.');
    }

    public function logout()
    {
        // Log the user out
        Auth::logout();

        // Redirect to the home page
        return redirect()->route('home');
    }
}
