@extends('master')


@section('content')
    <h4>Bienvenida al CHOFER</h4>

@endsection

@section('javascript')
    <script>
        socket.emit('nuevo_chofer', "Nuevo chofer registrado: {{ $chofer->id }}")
    </script>
@endsection
