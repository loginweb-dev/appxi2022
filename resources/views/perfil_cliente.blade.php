@extends('master')


@section('content')
    <h4>Perfil</h4>

    <a href="#" onclick="salir()" class="waves-effect waves-light btn">Salir</a>
@endsection

@section('javascript')

<script>
    $(document).ready(function(){

    });

    function salir() {
        localStorage.removeItem("miuser")
        M.toast({html: 'Vulve Pronto'})
    }
</script>

@endsection
