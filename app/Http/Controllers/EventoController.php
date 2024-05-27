<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EventoController extends Controller
{
    public function index()
    {
        // Obtiene todos los eventos de la base de datos
        $eventos = Evento::all();

        // Retorna la vista con los eventos
        return view('evento', compact('eventos'));
    }
}
