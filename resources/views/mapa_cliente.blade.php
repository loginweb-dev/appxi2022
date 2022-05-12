@extends('master')


@section('css')
    <style>
    #map {
        width: 100%;
        height: 400px;
    }
    </style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <img class="responsive-img" src="{{ url('storage').'/'.setting('site.banner_bienvenida') }}" alt="Perfil">
        <div class="col s12">
            <center>
                <h4>Mapa del Viaje</h4>
            </center>

            <div id="map"></div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script>
        $('document').ready(function () {
            set_origen()
        });

        function set_origen() {
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            var myLatLng = { lat: parseFloat(miuser.ciudad.latitud), lng: parseFloat(miuser.ciudad.longitud) }
            var map = new google.maps.Map(document.getElementById("map"), {
                center: myLatLng,
                zoom: 13,
            });
        }

        function error(err) {
            alert(err.message+" - Habilita tu Sensor GPS")
            console.warn('ERROR(' + err.code + '): ' + err.message)
        };
    </script>

@endsection
