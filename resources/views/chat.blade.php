<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!-- chat.blade.php -->

@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!-- Lista de amigos -->
            <ul class="list-group">
                @foreach ($amigos as $amigo)
                <li class="list-group-item">
                    <a href="{{ route('chatWithFriend', $amigo->id) }}">{{ $amigo->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-8">
            <!-- Chat con el amigo seleccionado -->
            <div id="chat" style="height: 400px; overflow-y: scroll;">
                @if (isset($friend))
                <h3>Chat con {{ $friend->name }}</h3>
                <div id="messages">
                    @foreach ($messages as $message)
                    <div class="message">
                        <strong>{{ $message->fromUser->name }}:</strong> {{ $message->content }}
                    </div>
                    @endforeach
                </div>
                <form id="sendMessageForm" action="{{ route('sendMessage', $friend->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
                @else
                <p>Selecciona un amigo para empezar a chatear.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


</body>
</html>