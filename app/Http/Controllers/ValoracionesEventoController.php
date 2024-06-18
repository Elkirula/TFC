<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\ValoracionesEvento;
use Illuminate\Support\Facades\Auth;

class ValoracionesEventoController extends Controller
{
    public function store(Request $request, Evento $evento)
    {
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:255',
        ]);

        $valoracion = new ValoracionesEvento();
        $valoracion->evento_id = $evento->id;
        $valoracion->user_id = Auth::id();
        $valoracion->puntuacion = $request->puntuacion;
        $valoracion->comentario = $request->comentario;
        $valoracion->save();

        return back()->with('success', 'Valoración añadida');
    }
}
