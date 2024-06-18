<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanelController;
// use App\Http\Controllers\StripeController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\Panel_rol_especialController;
use App\Http\Controllers\ValoracionesEventoController;
use App\Http\Controllers\ComprasController;


Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', [EventoController::class, 'index'])->name('home');
Route::get('/busca', [EventoController::class, 'buscar'])->name('busca');

//events
Route::get('/evento/{id}', [EventoController::class, 'show'])->name('evento.show');
Route::post('/evento/{id}/comentar', [EventoController::class, 'guardarComentario'])->name('evento.comentar');
Route::post('/evento/{id}/responder/{comentarioId}', [EventoController::class, 'responderComentario'])->name('evento.responder');
Route::get('/evento/{id}', [EventoController::class, 'show'])->name('evento.show');
Route::post('/puntuacion-evento', [EventoController::class, 'puntuacion'])->name('puntuacion.evento');
Route::middleware(['auth'])->group(function () {
Route::post('/evento/seguir-organizador/{organizadorId}', [EventoController::class, 'seguirOrganizador'])->name('seguirOrganizador');
});



Route::middleware(['auth'])->group(function () {
    Route::post('/evento/{evento}/comments', [EventoController::class, 'storeComment'])->name('comments.store');
    Route::post('/eventos/{evento}/valoraciones', [ValoracionesEventoController::class, 'store'])->name('valoraciones.store');
    Route::post('/comprar', [ComprasController::class, 'store'])->name('comprar');

});

//login
Route::middleware(['/login'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('home.index');
});


//Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'index']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Sing 
Route::post('/registro', [LoginController::class, 'registro'])->name('registro');


//hace falata inciar sesion primiro para acceder a estas rutas

// Panel users
Route::middleware(['auth'])->group(function () {
    Route::get('/panel_usuario', [PanelController::class, 'index'])->name('panel_usuario');
    Route::post('/panel_usuario/actualizar', [PanelController::class, 'actualizar'])->name('actualizar');
    Route::post('/panel_usuario', [PanelController::class, 'cambiar_contra'])->name('cambiar_contra');
    Route::post('/panel_usuario/enviar-solicitud/{amigo}', [PanelController::class, 'enviarSolicitud'])->name('enviarSolicitud');
    Route::post('/panel_usuario/aceptar-solicitud/{amigo}', [PanelController::class, 'aceptarSolicitud'])->name('aceptarSolicitud');
    Route::delete('/panel_usuario/eliminar-amigo/{amigo}', [PanelController::class, 'eliminarAmigo'])->name('eliminarAmigo');
    Route::get('/buscar-amigos', [PanelController::class, 'buscarAmigos'])->name('buscarAmigos');

});


//Panel de organizadores 
Route::middleware(['auth', CheckRole::class . ':admin,organizador,normal'])->group(function () {
    Route::get('/crear_evento', [Panel_rol_especialController::class, 'index'])->name('crear_evento');
    Route::post('/crear_evento', [Panel_rol_especialController::class, 'crearEvento'])->name('crear_evento.store');
    Route::post('/registrar-medidor', [Panel_rol_especialController::class, 'registrarMedidor'])->name('registrar_medidor');
    Route::post('/update-profile-especial', [Panel_rol_especialController::class, 'updateProfile'])->name('update-profile-especial');
    Route::delete('/eliminar_evento/{id}', [Panel_rol_especialController::class, 'eliminarEvento'])->name('eliminar_evento');
    Route::get('/chat/{friend}', [PanelController::class, 'chatWithFriend'])->name('chatWithFriend');
    Route::post('/send-message/{friend}', [PanelController::class, 'sendMessage'])->name('sendMessage');

});

//pago
// Route::middleware(['auth'])->group(function () {
//     Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');
// });
// Route::get('/checkout', 'App\Http\Controllers\StripeController@checkout')->name('checkout');
// Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');
// Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');
// Route::get('/success', function () {
//     return view('success'); 
// })->name('payment.success');

// Route::get('/cancel', function () {
//     return view('cancel');
// })->name('payment.cancel');
