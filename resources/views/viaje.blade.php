@extends('master')


@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col s12" >
          <center>
            <h4>Gracias por tu preferencia</h4>
            <p>Hola, gracias por tu preferencia, APPXI esta buscando un taxi ideal para ti, espera una notificacion por whatsapp cuando este listo tu taxi</p>
          </center>
          <table>
              <tbody>
                <tr>
                      <td>Viaje #</td>
                      <td><div id="miid"></div></td>
                </tr>
                <tr>
                    <td>Fecha</td>
                    <td><div id="fecha"></div></td>
                </tr>
                <tr>
                    <td>Cliente</td>
                    <td><div id="cliente"></div></td>
                </tr>
                <tr>
                    <td>Estado</td>
                    <td><div id="estado"></div></td>
                </tr>
                <tr>
                    <td>Precio Ofertado</td>
                    <td><div id="p_ofertado"></div></td>
                </tr>
                <tr>
                    <td>Distancia</td>
                    <td><div id="distancia"></div></td>
                </tr>
                <tr>
                    <td>Timepo</td>
                    <td><div id="tiempo"></div></td>
                </tr>
              </tbody>
          </table>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script>
        $('document').ready(function () {
            var viaje = JSON.parse(localStorage.getItem('viaje'))
            $("#miid").html("<p>"+viaje.id+"</p>")
            $("#fecha").html("<p>"+viaje.created_at+"</p>")
            $("#cliente").html("<p>"+viaje.cliente.nombres+' '+viaje.cliente.apellidos+"</p>")
            $("#estado").html("<p>"+viaje.estado.name+"</p>")
            $("#p_ofertado").html("<p>"+viaje.precio_inicial+" Bs.</p>")
            $("#distancia").html("<p>"+viaje.distancia+" Km</p>")
            $("#tiempo").html("<p>"+viaje.tiempo+" Min</p>")
        });
    </script>
@endsection
