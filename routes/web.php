<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\LoginController;

Route::get('/home', [EventoController::class, 'index'])->name('home');
Route::get('/busca', function () {
    return view('busca_evento');
});

Route::get('/pago', function () {
    return view('pago');
});
Route::get('/panel_usuario', function () {
    return view('panel_usuario');
})->name("panel_usuario");

//events
Route::get('/evento/{id}', [EventoController::class, 'show'])->name('evento.show');
Route::post('/evento/{id}/comentar', [EventoController::class, 'guardarComentario'])->name('evento.comentar');
Route::post('/evento/{id}/responder/{comentarioId}', [EventoController::class, 'responderComentario'])->name('evento.responder');


//login
Route::middleware(['/login'])->group(function () {
    Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('home.index');
    
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'index']); 
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


