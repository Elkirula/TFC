<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(isset($usuarios) && !$usuarios->isEmpty())
        <h3>Search Results</h3>
        <ul>
            @foreach($usuarios as $usuario)
            <li>
                {{ $usuario->name }} ({{ $usuario->email }})
                <!-- Form to send a friend request -->
                <form action="{{ route('enviarSolicitud', $usuario->id) }}" method="POST" class="sendRequestForm" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Send Friend Request</button>
                </form>
            </li>
            @endforeach
        </ul>
    @else
        <p>No results found.</p>
    @endif

</body>
</html>