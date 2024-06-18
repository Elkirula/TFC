<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComprasController extends Controller
{
    public function store(Request $request)
    {
        // Validate and store purchase data
        $compra = new Compras();
        $compra->user_id = Auth::id(); // ID of the authenticated user
        $compra->producto = $request->input('producto'); // Product name from the request
        $compra->precio = $request->input('precio'); // Price from the request
        $compra->save(); // Save the purchase record

        // Additional application logic...

        // Redirect user to the home route after purchase
        return redirect()->route('home');
    }
}
