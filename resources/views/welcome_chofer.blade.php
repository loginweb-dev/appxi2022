@extends('master')


@section('content')

<div class="container">
    <br>
    <div>
        <img class="responsive-img" src="{{ url('storage').'/'.setting('site.banner_bienvenida') }}" alt="APPXI" ><br>

        <h5 class="center-align"> Información</h5>

        <h6>
            Verificación
        </h6>
        <p>
            Tus datos y tus documentos están en verificación, el proceso tarda proximadamente 24 hrs,
            te notificaremos cualquier novedad al respecto.
        </p>
        <br>
        <h6>
            Créditos
        </h6>
        <p>
            El uso de la aplicación es totalmente gratuita, tanto para el chofer como para el cliente,
            podrás brindar tu servicio de chofer siempre y cuando estés verificado y tengas los créditos suficientes para
            realizar el servicio, dichos créditos tienen un costo.

            Pero tranquilo que solo por registrarte te regalaremos 500 créditos que te alcanzarán aproximadamente
            para X viajes de servicio.
        </p>
        <p>
            Hasta que seas verificado, si gustas puedes ir recargando créditos, ingresando al menú: "Cuenta".
        </p>
    </div>

</div>
<div id="modal1" class="modal">
    <div class="modal-content">
        <img class="responsive-img" src="{{ url('storage').'/'.setting('site.banner_bienvenida') }}" alt="APPXI" ><br>
        <h5 class="center-align">¡Bienvenido(a) a APPXI!</h5>
        <p class="center-align">Nos alegra que hayas decidido unirte a la mejor comunidad de
            "Servicio de Taxis", cada vez somos mas los integrantes y queremos que te sientas
            lo más cómodo(a) posible con nuestro servicio, nos carazterizamos por darle  una verdadera
            seguridad tanto al cliente cómo al chofer, al mismo tiempo una experiencia de excelente calidad.
        </p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
</div>

@endsection

@section('javascript')
    {{-- <script>
        socket.emit('nuevo_chofer', "Nuevo chofer registrado: {{ $chofer->id }}")
    </script> --}}
   <script>
        $('document').ready(function () {
            $('.modal').modal();
            $('#modal1').modal('open');

            var michofer=JSON.parse(localStorage.getItem('michofer'));

            var mensaje="*¡Bienvenido(a) a APPXI!* %0A Nos alegra que hayas decidido unirte a la mejor comunidad de 'Servicio de Taxis', cada vez somos mas los integrantes y queremos que te sientas lo más cómodo(a) posible con nuestro servicio, nos carazterizamos por darle una verdadera seguridad tanto al cliente cómo al chofer, al mismo tiempo una experiencia de excelente calidad"
            var wpp=  axios("https://chatbot.appxi.net/?type=text&phone="+michofer.telefono+"&message="+mensaje)

        });
   </script>
@endsection
