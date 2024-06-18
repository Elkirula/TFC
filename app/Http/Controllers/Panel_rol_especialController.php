<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Artista;
use App\Models\Multimedia;
use App\Models\Ubicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use App\Models\Categorias;
use App\Models\User;
class Panel_rol_especialController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        //Cargar el selecte
        $categorias = Categorias::all();
        // Obtener ganancias totales sumando los precios de todos los eventos del organizador
        $gananciasTotales = Evento::where('user_id', $user->id)->sum('precio');

        // Obtener la cantidad de seguidores (usuarios que siguen al organizador)
        $seguidores = $user->followers()->count();

        $eventos = Evento::with('ubicaciones')->where('user_id', $user->id)->get();
        return view('panel_rol_especial', compact('user', 'eventos','categorias', 'gananciasTotales', 'seguidores'));
    }

    public function crearEvento(Request $request)
{
    // Create a new location
    $ubicacion = new Ubicaciones();
    $ubicacion->nombre = (string) $request->input('nombre_lugar');
    $ubicacion->latitud = (string) $request->input('latitud');
    $ubicacion->longitud = (string) $request->input('longitud');
    $ubicacion->link = (string) $request->input('link_online');
    $ubicacion->save();

    // Create a new event
    $evento = new Evento();
    $evento->titulo = (string)$request->input('titulo');
    $evento->informacion = (string)$request->input('informacion');
    $evento->encabezado = (string)$request->input('encabezado');
    $evento->descripcion = implode(', ', $request->input('descripcion')); 
    $evento->fecha = (string)$request->input('fecha');
    $evento->hora_inicio = (string)$request->input('hora_inicio');
    $evento->hora_fin = (string)$request->input('hora_fin');
    $evento->categoria_id = $request->input('categoria');
    $evento->precio = (string)$request->input('precio');
    $evento->user_id = Auth::id();
    $evento->ubicacion_id = $ubicacion->id;
    $evento->save();

    // Save artist data
    $artistNames = $request->input('artistNombre');
    $descripcion = $request->input('descripcion');
    $artistMusica = $request->input('artistMusica');
    $artistImages = $request->file('artistImg');

    // Loop through each artist and save their details
    foreach ($artistNames as $index => $artistName) {
        $artista = new Artista();
        $artista->nombre = $artistName;
        $artista->audio = $artistMusica[$index];
        $artista->descripcion = $descripcion[$index];

        // Save artist image if available
        if ($artistImages && isset($artistImages[$index])) {
            $artista->foto = file_get_contents($artistImages[$index]->getPathname());
        }
        $artista->save();

        // Associate artist with the event
        $evento->artistas()->attach($artista->id);
    }

    // Save multimedia file associated with the event
    $archivoP = $request->file('archivo');
    $multimedia = new Multimedia();
    $multimedia->video = (string) $request->input('video');
    $multimedia->evento_id = $evento->id;
    $multimedia->nombre = (string) $request->input('tituloVideo');
    $multimedia->archivo = file_get_contents($archivoP->getPathname());
    $multimedia->save();

    // Redirect to the event creation page with a success message
    return redirect()->route('crear_evento')->with('success', 'Event created successfully');
}


    public function eliminarEvento($id)
    {
        // Encuentra el evento por su ID
        $evento = Evento::find($id);

        // Verifica si el evento existe
        if (!$evento) {
            return response()->json(['error' => 'El evento no existe'], 404);
        }

        // Elimina el evento
        $evento->delete();

        // Redirecciona de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'El evento ha sido eliminado correctamente.');
    }
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $user->foto = file_get_contents($file->getPathname());
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    // public function registrarMedidor(Request $request)
    // {
    //     $user = Auth::user();
    //     $stripeCustomerId = $user->stripe_customer_id; // Asegúrate de tener el ID del cliente de Stripe guardado en el usuario
    //     $value = $request->input('value'); // Valor a registrar en el medidor

    //     if (!$stripeCustomerId) {
    //         return response()->json(['success' => false, 'message' => 'El usuario no tiene un ID de cliente de Stripe registrado.'], 400);
    //     }

    //     $client = new Client();

    //     try {
    //         $response = $client->post('https://api.stripe.com/v1/billing/meter_events', [
    //             'auth' => 'sk_test_51PQ6aQLDBgcsEFMikYPkvcoFWz2IA12w83iN8dul8I0D9lDdSbCLuxU4Br8Zj6iIvp09OFLOva4T4aYMpYm74Xr900Hbpg02on',
    //             'form_params' => [
    //                 'event_name' => 'medidor',
    //                 'timestamp' =>time(),
    //                 'customer' => 'cus_QH2hhwKROuoOss', // Asegúrate de que el ID del cliente esté siendo pasado aquí
    //                 'payload[value]' => $value,
    //             ],
    //         ]);

    //         if ($response->getStatusCode() == 200) {
    //             return response()->json(['success' => true, 'message' => 'Medidor registrado correctamente']);
    //         } else {
    //             return response()->json(['success' => false, 'message' => 'Error al registrar el medidor'], $response->getStatusCode());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => 'Error al registrar el medidor: ' . $e->getMessage()], 500);
    //     }
    // }

}
