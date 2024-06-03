<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Ubicacion;
use App\Models\ChatEvento;

class EventoController extends Controller
{
    public function index()
    {
        // Obtiene todos los eventos de la base de datos
        $eventos = Evento::with('multimedia')->get();

        // Retorna la vista con los eventos
        return view('home', compact('eventos'));
    }


    public function show($id)
    {
        // Obtiene el evento específico con sus artistas y multimedia
        $evento = Evento::with('artistas', 'ubicaciones', 'multimedia', 'comentarios')->findOrFail($id);


        $eventosRelacionados = Evento::where('categoria_id', '2')
            ->where('id', '!=', $id)
            ->get();

        // Extraer el ID del video de YouTube
        $url = $evento->multimedia->video;
        $youtubeVideoId = substr($url, strpos($url, 'v=') + 2);
        // Retorna la vista con el evento específico
        return view('evento', compact('evento', 'youtubeVideoId', 'eventosRelacionados'));
    }

    public function guardarComentario(Request $request, $id)
    {
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        $evento = Evento::findOrFail($id);
        $comentario = new ChatEvento();
        $comentario->evento_id = $evento->id;
        $comentario->user_id = auth()->user()->id;
        $comentario->contenido = $request->contenido;
        $comentario->save();

        return redirect()->back()->with('success', 'Comentario guardado correctamente.');
    }

    public function responderComentario(Request $request, $id, $comentarioId)
    {
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        $comentarioPadre = ChatEvento::findOrFail($comentarioId);
        $evento = $comentarioPadre->evento;
        $comentario = new ChatEvento();
        $comentario->evento_id = $evento->id;
        $comentario->user_id = auth()->user()->id;
        $comentario->contenido = $request->contenido;
        $comentario->parent_id = $comentarioPadre->id;
        $comentario->save();

        return redirect()->back()->with('success', 'Respuesta guardada correctamente.');
    }



}
