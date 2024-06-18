<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Ubicacion;
use App\Models\Categorias;
use App\Models\ChatEvento;
use App\Models\ValoracionesEvento;
use \App\Models\User;
use \RyanChandler\Comments\Models\Comment;
use Illuminate\Support\Facades\Auth;


class EventoController extends Controller
{
    public function index()
    {
        // Obtiene todos los eventos de la base de datos
        $eventos = Evento::with('multimedia')->get();
        $user = Auth::user();
        $usuarios = User::all();
        $categorias = Categorias::all();

        $eventos_top = Evento::with('multimedia')
            ->withCount('valoraciones')
            ->orderBy('valoraciones_count', 'desc')
            ->get()
            ->map(function ($evento) {
                $evento->valoracion_media = $evento->valoraciones()->avg('puntuacion');
                return $evento;
            });

        $eventos_musica = Evento::where('categoria_id', 11)
            ->with('multimedia')
            ->get();

        // Obtener los organizadores ordenados por número de seguidores
        $organizadores = User::where('role', 'organizador')
            ->withCount('followers')
            ->orderBy('followers_count', 'desc')
            ->take(3) // Tomar máximo tres organizadores
            ->get();

        // Retorna la vista con los eventos
        return view('home', compact('eventos', 'user', 'usuarios', 'eventos_top', 'eventos_musica', 'categorias', 'organizadores'));
    }




    public function show($id)
    {
        // Retrieve the event with its related artists, locations, multimedia, and comments
        $evento = Evento::with('artistas', 'ubicaciones', 'multimedia', 'comentarios')->findOrFail($id);
        $categorias = Categorias::all();

        // If the user is authenticated, get the user's rating for the event
        if (Auth::user()) {
            $user = Auth::user();
            $puntuacion = ValoracionesEvento::where('user_id', $user->id)
                ->where('evento_id', $id)
                ->value('puntuacion');
        } else {
            $puntuacion = "";
        }

        // Retrieve the category of the event
        $categoria_id = $evento->categoria_id;

        // Get related events from the same category, excluding the current event
        $eventosRelacionados = Evento::where('categoria_id', $categoria_id)
            ->where('id', '!=', $id)
            ->get();

        // Extract the YouTube video ID if the event has a multimedia video
        if ($evento->multimedia && $evento->multimedia->video != null) {
            $url = $evento->multimedia->video;
            $youtubeVideoId = substr($url, strpos($url, 'v=') + 2);
        } else {
            $youtubeVideoId = "";
        }

        // Calculate the average rating
        $valoracion_media = $evento->valoraciones()->avg('puntuacion');
        // Return the view with the specific event details
        return view('evento', compact('evento', 'youtubeVideoId', 'puntuacion', 'eventosRelacionados', 'categorias', 'valoracion_media'));
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $categoria_id = $request->input('categoria_id');
        $categorias = Categorias::all();

        $eventos = Evento::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('titulo', 'LIKE', "%{$query}%")
                ->orWhereHas('ubicaciones', function ($q) use ($query) {
                    $q->where('nombre', 'LIKE', "%{$query}%");
                });
        })
            ->when($categoria_id, function ($queryBuilder) use ($categoria_id) {
                return $queryBuilder->where('categoria_id', $categoria_id);
            })
            ->paginate(9);

        return view('busca_evento', compact('eventos', 'categorias'));
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


    public function storeComment(Request $request, Evento $evento)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        // Obtener el usuario actual que está realizando el comentario
        $user = Auth::user();

        // Añadir el comentario, pasando el usuario y el contenido del comentario
        $evento->comment($request->comment, $user, parent: $request->parent_id ? Comment::find($request->parent_id) : null);

        return back()->with('success', 'Comentario añadido');
    }

    public function puntuacion(Request $request)
    {
        $user = Auth::user();
        if (Auth::user()) {


            // Validar los datos recibidos
            $request->validate([
                'star' => 'required|integer|min:1|max:5',
                'evento_id' => 'required|integer|exists:eventos,id'
            ]);

            // Insertar la puntuación en la base de datos
            $puntuacion = new ValoracionesEvento();
            $puntuacion->user_id = auth()->user()->id;
            $puntuacion->evento_id = $request->input('evento_id');
            $puntuacion->puntuacion = $request->input('star');
            $puntuacion->updated_at = $request->input('updated_at');
            $puntuacion->created_at = $request->input('created_at');
            $puntuacion->save();
            return redirect()->back()->with('success', 'Puntuación guardada correctamente.');
        } else {
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->back();
        }
    }
    public function seguirOrganizador(Request $request, $organizadorId)
    {
        /** @var \App\Models\User $user */

        $user = auth()->user();
        $organizador = User::findOrFail($organizadorId);

        // Verifica si el usuario ya sigue al organizador
        if ($user->isFollowing($organizador)) {
            return redirect()->back()->with('warning', 'Ya sigues a este organizador.');
        }

        // Agrega la relación de seguimiento
        $user->follow($organizador);

        return redirect()->back()->with('success', 'Ahora estás siguiendo a ' . $organizador->name);
    }
}
