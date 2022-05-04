@extends('master')

@section('css')

@endsection

@section('content')
    <div class="container-fluid">
      <div class="row">
        <div class="col s12 m4 l6">
          <!-- Your content here -->
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
                    {{-- <h6>Cual es tu Telefono</h6> --}}
                    <input placeholder="Ingresa tu telefono - 8 digitos" id="telefono" type="number" class="validate">
                </div>
                <div class="col s3">
                    <div class="dividir"></div>
                    {{-- <label>Consultar</label> --}}
                    <a href="#" onclick="get_chofer()" class="waves-effect waves-light btn"><i class="material-icons">search</i></a>
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

        } else {
            $('#modal1').modal('open');
        }
    });

    async function get_chofer() {
        var telefono = $("#telefono").val()
        var michofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+telefono)
        console.log(michofer)
        if (michofer.data) {
            localStorage.setItem('michofer', JSON.stringify(michofer.data));
            $('#modal1').modal('close');
        } else {
            location.href= '/chofer/crear'
        }
    }
</script>
@endsection
