<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;

Route::get('/', function () {
    return view('home');
});

Route::get('/busca', function () {
    return view('busca_evento');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/evento', [EventoController::class, 'index'])->name('evento.index');
