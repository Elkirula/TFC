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
        // Valida y guarda los datos de la compra
        $compra = new Compras();
        $compra->user_id = Auth::id(); // ID del usuario autenticado
        $compra->producto = $request->input('producto');
        $compra->precio = $request->input('precio');
        $compra->save();

        // Otra lógica de tu aplicación...

        return redirect()->route('home'); 
    }
}
