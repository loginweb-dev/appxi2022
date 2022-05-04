@extends('master')


@section('content')
    <h4>Viaje: {{ $id }}</h4>
    <code>
        @php
            $viaje = App\Viaje::find($id);
        @endphp
        {{ $viaje }}
    </code>
@endsection

@section('javascript')
<script>
    socket.emit("nuevo_viaje", "Nuevo viaje registrado: {{ $id }}")
</script>

@endsection
