@extends('master')

@section('css')

@endsection

@section('content')
    <div class="container-fluid">
      <div class="row">
        <div class="col s12 m4 l6" id="miul" hidden>
          <center>
            <h4>Monitor de Viajes</h4>
          </center>
          <ul class="collection">
              @php
                  $viajes = App\Viaje::where('status_id', 2)->with('cliente')->get();
              @endphp
              @if ($viajes)
                @foreach ($viajes as $item)
                    <li class="collection-item avatar">
                        <img src="{{ setting('admin.url_storage').$item->cliente->perfil }}" alt="" class="circle">
                        <span class="title">{{ $item->cliente->nombres.' '.$item->cliente->apellidos }}</span>
                        <p>Fecha y Hora: {{ $item->created_at }}</p>
                        <p>Precio Ofertado: {{ $item->precio_inicial }} Bs</p>
                        <p>Distancia: {{ $item->distancia }} Km</p>
                        <p>Tiempo: {{ $item->tiempo }} Minutos</p>
                        <a href="#" class="secondary-content tooltipped" data-position="bottom" data-tooltip="Detalle del Viaje"><i class="material-icons">map</i></a>
                    </li>
                @endforeach
              @else
                  <li>
                      <p>No hay viajes para negociar</p>
                  </li>
              @endif
          </ul>
        </div>
      </div>
    </div>
    <div id="modal1" class="modal bottom-sheet">
        <div class="modal-content">
            <h5>Cual es tu Telefono</h5>
            <div class="row">
                <div class="col s9">
                    <input placeholder="Ingresa tu telefono - 8 digitos" id="telefono" type="number" class="validate">
                </div>
                <div class="col s3">
                    <a id="btn_telefono" href="#" onclick="get_chofer()" class="waves-effect waves-light btn"><i class="material-icons">search</i></a>
                </div>
            </div>
            <div class="row">
                <div class="col s9">
                    <input placeholder="PIN - 4 digitos" id="pin" type="number" class="validate" disabled>
                </div>
                <div class="col s3">
                    <a id="btn_pin" href="#" onclick="get_pin()" class="waves-effect waves-light btn" disabled><i class="material-icons">key</i></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    $('document').ready(function () {
        $('.tooltipped').tooltip();
        $('.modal').modal();
        var michofer = JSON.parse(localStorage.getItem('michofer'))
        if (michofer) {
            M.toast({html: 'Bienvenido! '+michofer.nombres+' '+michofer.apellidos})
            $("#miul").attr('hidden', false);
            //$("#miul").attr('hidden', false);
        } else {
            $('#modal1').modal('open');
        }
    });

    async function get_chofer() {
        var telefono = $("#telefono").val()
        if (telefono == '') {
                M.toast({html : 'Ingresa un telefono valido'})
        } else {
            var michofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+telefono)
            if (michofer.data) {
            var pin = Math.floor(1000 + Math.random() * 9000);
            var chofer = await axios("{{ setting('admin.url_api') }}chofer/pin/save/"+michofer.data.id+"/"+pin)
            //send chatbot
            var mensaje="Hola, tu pin para acceder a APPXI es: "+pin
            var wpp= await axios("https://chatbot.appxi.net/?type=text&phone="+telefono+"&message="+mensaje)
            M.toast({html : 'Revisa tu Whatsapp'})
            $("#telefono").attr('disabled', true);
            $("#btn_telefono").attr('disabled', true);
            $("#pin").attr('disabled', false);
            $("#btn_pin").attr('disabled', false);
            } else {
                location.href= '/chofer/crear'
            }
        }
    }

    async function get_pin() {
        var pin = $("#pin").val()
        var telefono = $("#telefono").val()
        var michofer = await axios("{{ setting('admin.url_api') }}chofer/pin/get/"+telefono+"/"+pin)
        if (michofer.data) {
            localStorage.setItem('michofer', JSON.stringify(michofer.data))
            $('#modal1').modal('close')
            M.toast({html : 'Bienvenido'})
            $("#miul").attr('hidden', false);
        }else{
            M.toast({html : 'Credenciales Invalidas'})
        }
    }
</script>
@endsection
