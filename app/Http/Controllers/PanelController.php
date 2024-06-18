<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Categorias;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Compras;

use RyanChandler\Comments\Commentable;
use RyanChandler\Comments\Models\Comment;
use App\Models\Message;

class PanelController extends Controller
{
    // This constructor is commented out but sets the Stripe API key if uncommented
    // public function __construct()
    // {
    //     // Set the Stripe secret key
    //     Stripe::setApiKey(config('services.stripe.secret'));
    // }

    public function index(Request $request)
    {
        // Retrieve all categories
        $categorias = Categorias::all();

        $compras = Compras::where('user_id', Auth::id())->get();

        // Get the authenticated user
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get the user's friends and pending friend requests
        $amigos = $user->getFriends();
        $solicitudesPendientes = $user->getFriendRequests();

        // Search for users based on query
        $query = $request->input('query');
        $usuarios = collect();
        if ($query) {
            $usuarios = User::where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->get();
        }

        // Return the view with the necessary data
        return view('panel_usuario', compact('user', 'categorias', 'amigos', 'solicitudesPendientes', 'query', 'usuarios', 'compras'));
    }

    public function actualizar(Request $request)
    {
        // Get the authenticated user
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Update user's name and email
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function cambiar_contra(Request $request)
    {
        // Get the authenticated user
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'The current password is incorrect.');
        }

        // Check if the new password matches the confirmation
        if ($request->input('new_password') !== $request->input('new_password_confirmation')) {
            return redirect()->back()->with('error', 'The new passwords do not match.');
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Password has been changed successfully.');
    }

    public function buscarAmigos(Request $request)
    {
        $query = $request->input('query');
        $usuarios = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        if ($request->ajax()) {
            return view('busca_amigos_resultado', compact('usuarios'))->render();
        }

        return view('panel_usuario', compact('usuarios', 'query'));
    }

    public function enviarSolicitud($amigoId)
    {
        // Find the friend by ID
        $amigo = User::find($amigoId);

        if ($amigo) {
            // Get the authenticated user
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Send a friend request
            $user->befriend($amigo);
            return back()->with('success', 'Friend request sent.');
        }

        return back()->with('error', 'User not found.');
    }

    public function aceptarSolicitud(User $amigo)
    {
        // Get the authenticated user
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($amigo) {
            // Accept the friend request
            $user->acceptFriendRequest($amigo);
            return back()->with('success', 'Friend request accepted.');
        }

        return back()->with('error', 'User not found.');
    }

    public function eliminarAmigo(User $amigoId)
    {
        // Get the authenticated user
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Find the friend by ID
        $amigo = User::find($amigoId);
        if ($amigo) {
            // Unfriend the user
            $user->unfriend($amigo);
            return back()->with('success', 'Friend removed.');
        }

        return back()->with('success', 'Friend removed.');
    }

    public function chatWithFriend(User $friend)
    {
        // Get the authenticated user
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Retrieve messages between the user and the friend
        $messages = Message::where(function ($query) use ($user, $friend) {
            $query->where('from_user_id', $user->id)
                ->where('to_user_id', $friend->id);
        })->orWhere(function ($query) use ($user, $friend) {
            $query->where('from_user_id', $friend->id)
                ->where('to_user_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        // Get the user's friends
        $amigos = $user->friends();

        // Return the chat view with the necessary data
        return view('chat', compact('user', 'friend', 'messages', 'amigos'));
    }

    public function sendMessage(Request $request, User $friend)
    {
        // Validate the request data
        $request->validate([
            'message' => 'required|string',
        ]);

        // Create a new message
        $message = new Message();
        $message->from_user_id = Auth::id();
        $message->to_user_id = $friend->id;
        $message->content = $request->input('message');
        $message->save();

        // Redirect to the chat with the friend with a success message
        return redirect()->route('panel_usuario', $friend->id)->with('success', 'Message sent successfully.');
    }
}
