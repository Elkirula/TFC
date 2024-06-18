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
        // Retrieve all events from the database
        $eventos = Evento::with('multimedia')->get();
        $user = Auth::user(); // Get the authenticated user
        $usuarios = User::all(); // Get all users
        $categorias = Categorias::all(); // Get all categories

        // Retrieve top-rated events with their average ratings
        $eventos_top = Evento::with('multimedia')
            ->withCount('valoraciones')
            ->orderBy('valoraciones_count', 'desc')
            ->get()
            ->map(function ($evento) {
                $evento->valoracion_media = $evento->valoraciones()->avg('puntuacion');
                return $evento;
            });

        // Retrieve music events specifically
        $eventos_musica = Evento::where('categoria_id', 11)
            ->with('multimedia')
            ->get();

        // Retrieve organizers sorted by number of followers
        $organizadores = User::where('role', 'organizador')
            ->withCount('followers')
            ->orderBy('followers_count', 'desc')
            ->take(3) // Get maximum of three organizers
            ->get();

        // Return the view with events data
        return view('home', compact('eventos', 'user', 'usuarios', 'eventos_top', 'eventos_musica', 'categorias', 'organizadores'));
    }

    public function show($id)
    {
        // Retrieve a specific event with its related data: artists, locations, multimedia, and comments
        $evento = Evento::with('artistas', 'ubicaciones', 'multimedia', 'comentarios')->findOrFail($id);
        $categorias = Categorias::all(); // Get all categories

        // If user is authenticated, retrieve their rating for the event
        if (Auth::user()) {
            $user = Auth::user();
            $puntuacion = ValoracionesEvento::where('user_id', $user->id)
                ->where('evento_id', $id)
                ->value('puntuacion');
        } else {
            $puntuacion = "";
        }

        // Retrieve the category ID of the event
        $categoria_id = $evento->categoria_id;

        // Get related events from the same category, excluding the current event
        $eventosRelacionados = Evento::where('categoria_id', $categoria_id)
            ->where('id', '!=', $id)
            ->get();

        // Extract YouTube video ID if the event has multimedia video
        if ($evento->multimedia && $evento->multimedia->video != null) {
            $url = $evento->multimedia->video;
            $youtubeVideoId = substr($url, strpos($url, 'v=') + 2);
        } else {
            $youtubeVideoId = "";
        }

        // Calculate average rating for the event
        $valoracion_media = $evento->valoraciones()->avg('puntuacion');

        // Return the view with specific event details
        return view('evento', compact('evento', 'youtubeVideoId', 'puntuacion', 'eventosRelacionados', 'categorias', 'valoracion_media'));
    }

    public function buscar(Request $request)
    {
        // Get search query and category ID from the request
        $query = $request->input('query');
        $categoria_id = $request->input('categoria_id');
        $categorias = Categorias::all(); // Get all categories

        // Search for events based on title or location name
        $eventos = Evento::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('titulo', 'LIKE', "%{$query}%")
                ->orWhereHas('ubicaciones', function ($q) use ($query) {
                    $q->where('nombre', 'LIKE', "%{$query}%");
                });
        })
            ->when($categoria_id, function ($queryBuilder) use ($categoria_id) {
                return $queryBuilder->where('categoria_id', $categoria_id);
            })
            ->paginate(9); // Paginate results

        // Return the view with search results
        return view('busca_evento', compact('eventos', 'categorias'));
    }

    public function guardarComentario(Request $request, $id)
    {
        // Validate comment content
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        // Find the event to which the comment belongs
        $evento = Evento::findOrFail($id);

        // Save the new comment
        $comentario = new ChatEvento();
        $comentario->evento_id = $evento->id;
        $comentario->user_id = auth()->user()->id;
        $comentario->contenido = $request->contenido;
        $comentario->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Comment saved successfully.');
    }

    public function responderComentario(Request $request, $id, $comentarioId)
    {
        // Validate response content
        $request->validate([
            'contenido' => 'required|string|max:255',
        ]);

        // Find the parent comment to which the response belongs
        $comentarioPadre = ChatEvento::findOrFail($comentarioId);
        $evento = $comentarioPadre->evento;

        // Save the response comment
        $comentario = new ChatEvento();
        $comentario->evento_id = $evento->id;
        $comentario->user_id = auth()->user()->id;
        $comentario->contenido = $request->contenido;
        $comentario->parent_id = $comentarioPadre->id;
        $comentario->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Response saved successfully.');
    }

    public function storeComment(Request $request, Evento $evento)
    {
        // Validate comment data
        $request->validate([
            'comment' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        // Get the current user making the comment
        $user = Auth::user();

        // Add the comment, passing user and comment content
        $evento->comment($request->comment, $user, parent: $request->parent_id ? Comment::find($request->parent_id) : null);

        // Redirect back with success message
        return back()->with('success', 'Comment added');
    }

    public function puntuacion(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        if (Auth::user()) {

            // Validate received data
            $request->validate([
                'star' => 'required|integer|min:1|max:5',
                'evento_id' => 'required|integer|exists:eventos,id'
            ]);

            // Insert rating into the database
            $puntuacion = new ValoracionesEvento();
            $puntuacion->user_id = auth()->user()->id;
            $puntuacion->evento_id = $request->input('evento_id');
            $puntuacion->puntuacion = $request->input('star');
            $puntuacion->updated_at = $request->input('updated_at');
            $puntuacion->created_at = $request->input('created_at');
            $puntuacion->save();
            return redirect()->back()->with('success', 'Rating saved successfully.');
        } else {
            // Redirect back with success message
            return redirect()->back();
        }
    }

    public function seguirOrganizador(Request $request, $organizadorId)
    {
        /** @var \App\Models\User $user */

        // Get the authenticated user
        $user = auth()->user();
        $organizador = User::findOrFail($organizadorId);

        // Check if the user already follows the organizer
        if ($user->isFollowing($organizador)) {
            return redirect()->back()->with('warning', 'You are already following this organizer.');
        }

        // Add the follow relationship
        $user->follow($organizador);

        return redirect()->back()->with('success', 'You are now following ' . $organizador->name);
    }
}
