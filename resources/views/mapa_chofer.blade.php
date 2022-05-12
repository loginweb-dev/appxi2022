@extends('master')

@section('css')

<style>
    #mimapa {
        width: 100%;
        height: 650px;
    }
    .oferta {
        width: 100%;
        height: 350px;
    }
    .label{
        text-align: right;
        align-content: right;
        align-items: right;
    }
    </style>

@endsection


@section('content')

    <div class="container-fluid">
        <div class="row">
            <img class="responsive-img" src="{{ url('storage').'/'.setting('site.banner_bienvenida') }}" alt="Perfil">
            {{-- <h5 class="center-align">Mapa del Viaje en Proceso</h5> --}}

            <div class="col s12">
                <p>Debe ir a recoger al cliente en el lugar indicado (A), para posteriormente llevarlo a su destino (B).</p>
                <div id="mimapa"></div>


                <div class="col s7">
                    <div id="distancia" class="col s6"></div>
                    <div id="tiempo" class="col s6"></div>
                </div>

                <div id="recoger_cliente" class="col s5"></div>

                <div id="detalles_2" class="col s5" hidden></div>

                <div>
                    <div id="detalles_3" class="col s7"></div>
                    <div id="detalles_4" class="col s5"></div>
                </div>

            </div>

        </div>

    </div>


@endsection

@section('javascript')
    <script>
        $('document').ready(function () {

            cargar();

            // mostrar();
        });

        async function mostrar() {

            var michofer = JSON.parse(localStorage.getItem('michofer'))
            var chofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+michofer.telefono)
            var consulta_viaje_disponible= await axios("{{ setting('admin.url_api')}}chofer_viaje_consulta/"+chofer.data.id)

            var miul=''
            miul= miul+"<div id='mioferta' class='oferta' ><div id='mimapa' class='mimapa' ></div><div class='col s7'></div><div class='col s5'> <button class='btn waves-effect waves-light' type='submit' onclick='conluir_viaje("+consulta_viaje_disponible.data.id+")' name='action'>Finalizado<i class='material-icons right'>send</i></button>           </div></div>"
            miul=miul+"<div id='detalles'><div class='col s7'><label for='text_detalle'>Detalle Cancelación</label><input placeholder='Ingrese referencia' id='text_detalle' type='text'  class='validate'></div><div class='col s5'>   <br><a class=' waves-effect waves-light btn red' onclick='cancelar_viaje("+consulta_viaje_disponible.data.id+")'>Cancelar</a> </div></div>"
            $("#milist").html(miul)



            //detalles_viaje(consulta_viaje_disponible.data.id)
        }

        async function mostrar2() {
            var michofer = JSON.parse(localStorage.getItem('michofer'))
            var chofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+michofer.telefono)
            var consulta_viaje_disponible= await axios("{{ setting('admin.url_api')}}chofer_viaje_consulta/"+chofer.data.id)

            var distancia=''
            distancia=distancia+"<label for='text_distancia'>Distancia Aproximada</label><input id='text_distancia' type='text'  class='validate' readonly>"
            $("#distancia").html(distancia)

            var tiempo=''
            tiempo=tiempo+"<label for='text_tiempo'>Tiempo Aproximado</label><input id='text_tiempo' type='text'  class='validate' readonly>"
            $("#tiempo").html(tiempo)

            var recoger_cliente=''
            recoger_cliente=recoger_cliente+"<br><button class='btn waves-effect waves-light' type='submit' onclick='cliente_recogido("+consulta_viaje_disponible.data.id+")' name='action'>Recogido<i class='material-icons right'>send</i></button>"
            $('#recoger_cliente').html(recoger_cliente)


            var detalles_2=''
            detalles_2= detalles_2+"<br><button class='btn waves-effect waves-light' type='submit' onclick='conluir_viaje("+consulta_viaje_disponible.data.id+")' name='action'>Finalizado<i class='material-icons right'>send</i></button>"
            $("#detalles_2").html(detalles_2)

            var detalles_3=''
            detalles_3=detalles_3+"<label for='text_detalle'>Detalle Cancelación</label><input placeholder='Ingrese referencia' id='text_detalle' type='text'  class='validate'></div><div class='col s5'>"
            $("#detalles_3").html(detalles_3)

            var detalles_4=''
            detalles_4=detalles_4+"<br><a class=' waves-effect waves-light btn red' onclick='cancelar_viaje("+consulta_viaje_disponible.data.id+")'>Cancelar</a> "
            $("#detalles_4").html(detalles_4)

        }

        async function mostrar3() {
            var michofer = JSON.parse(localStorage.getItem('michofer'))
            var chofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+michofer.telefono)
            var consulta_viaje_disponible= await axios("{{ setting('admin.url_api')}}chofer_viaje_consulta/"+chofer.data.id)

            var informacion_viaje=''
            informacion_viaje= informacion_viaje+"<label for='text_detalle'>Detalle Cancelación</label><input placeholder='Ingrese referencia' id='text_detalle' type='text'  class='validate'>"
            $("#informacion_viaje").html(informacion_viaje)

        }

        async function cargar() {
            var michofer = JSON.parse(localStorage.getItem('michofer'))
            var chofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+michofer.telefono)
            var viaje_encurso=await  await axios("{{ setting('admin.url_api')}}viaje_chofer_encurso/"+chofer.data.id)
            var consulta_viaje_disponible= await axios("{{ setting('admin.url_api')}}chofer_viaje_consulta/"+chofer.data.id)



            if(consulta_viaje_disponible.data){
                var options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                navigator.geolocation.getCurrentPosition(set_origen, error, options);

                mostrar2();
            }
            if(viaje_encurso.data){
                console.log("hola, si entré")
                var options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                navigator.geolocation.getCurrentPosition(set_origen2, error, options);
                //liente_recogido();
            }

        }

        async function cliente_recogido(id) {
            var recogido= await axios("{{setting('admin.url_api')}}cliente_recogido/"+id)

            $("#detalles_2").attr('hidden', false);
            $("#recoger_cliente").attr('hidden', true);

            cargar();


            // var options = {
            //     enableHighAccuracy: true,
            //     timeout: 5000,
            //     maximumAge: 0
            // };
            // navigator.geolocation.getCurrentPosition(set_origen, error, options);
            set_origen2();


            // mostrar3()
            // ruta2()
        }


        async function conluir_viaje(id) {
            console.log("Concluido: "+id)
            var viaje_concluido=await axios("{{ setting('admin.url_api')}}concluir_viaje/"+id)
            if(viaje_concluido){
                var michofer = JSON.parse(localStorage.getItem('michofer'))
                var chofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+michofer.telefono)

                var estado= await axios("{{setting('admin.url_api')}}update_estado/chofer/"+chofer.data.id+"/"+1)
                location.href='/viajes/monitor'
            }
        }

        async function cancelar_viaje(id) {
            console.log("Cancelado: "+id)
            var detalle=$('#text_detalle').val() ? $('#text_detalle').val():null

            if(detalle){
                var viaje_cancelado= await axios("{{setting('admin.url_api')}}cancelar_viaje/"+id+"/"+detalle)
                if(viaje_cancelado){
                    var michofer = JSON.parse(localStorage.getItem('michofer'))
                    var chofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+michofer.telefono)

                    var estado= await axios("{{setting('admin.url_api')}}update_estado/chofer/"+chofer.data.id+"/"+1)
                    location.href='/viajes/monitor'
                }
            }
            else{
                M.toast({html:'Tiene que escribir el motivo de su cancelación'})
            }

        }

        //ex detalle_viaje
        async function ruta2(data) {

            //$("#mioferta").attr('hidden', false);
            var table= await axios("{{setting('admin.url_api')}}viaje/"+data)
            var origen= await axios("{{setting('admin.url_api')}}ubicacion/"+table.data.origen_location)
            var destino= await axios("{{setting('admin.url_api')}}ubicacion/"+table.data.destino_location)

            var myLatLng = { lat: parseFloat(origen.data.latitud), lng: parseFloat(origen.data.longitud) }
            var destinoLatLong= { lat: parseFloat(destino.data.latitud), lng:parseFloat(destino.data.longitud)}
            var map = new google.maps.Map(document.getElementById("mimapa"), {
                    center: destinoLatLong,
                    zoom: 13,
            });
            var viaje = {
                origin: myLatLng,
                destination: destinoLatLong,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            var directionsDisplay = new google.maps.DirectionsRenderer();
            directionsDisplay.suppressMarkers = true;
            var directionsService = new google.maps.DirectionsService();
            directionsDisplay.setMap(map);

            directionsService.route(viaje, async function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response)
                    $("#text_distancia").val(response.routes[0].legs[0].distance.text);
                    $("#text_tiempo").val(response.routes[0].legs[0].duration.text);
                }
            });
        }

        function error(err) {
            alert(err.message+" "+err.code+" - Habilita tu Sensor GPS")
            console.warn('ERROR(' + err.code + '): ' + err.message)
        }

        function set_origen(pos) {
            console.log(pos)
            var crd = pos.coords
            var radio = pos.accuracy
            var myLatLng = { lat: pos.coords.latitude, lng: pos.coords.longitude }
            var map = new google.maps.Map(document.getElementById("mimapa"), {
                center: myLatLng,
                zoom: 15,
            });
            var marker1 = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                position: myLatLng,
                map,
                label: "YO"
            });

            ruta1(myLatLng, map)

            // var op1=consulta_viaje_disponible();
            // var op2=viaje_encurso();
            // if(op1){
            //     ruta1(myLatLng, map)
            // }
            // else{
            //     ruta2(op2)
            // }




        }

        function set_origen2(pos){
            console.log(pos)
            var crd = pos.coords
            var radio = pos.accuracy
            var myLatLng = { lat: pos.coords.latitude, lng: pos.coords.longitude }
            var map = new google.maps.Map(document.getElementById("mimapa"), {
                center: myLatLng,
                zoom: 15,
            });
            var marker1 = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                position: myLatLng,
                map,
                label: "YO"
            });

            //ruta1(myLatLng, map)

            var op2=viaje_encurso();
            ruta2(op2)

            // var op1=consulta_viaje_disponible();
            // var op2=viaje_encurso();
            // if(op1){
            //     ruta1(myLatLng, map)
            // }
            // else{
            //     ruta2(op2)
            // }
        }

        async function consulta_viaje_disponible(){
            var michofer = JSON.parse(localStorage.getItem('michofer'))
            var chofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+michofer.telefono)
            var consulta_viaje_disponible= await axios("{{ setting('admin.url_api')}}chofer_viaje_consulta/"+chofer.data.id)

            if(consulta_viaje_disponible.data){
                return true;
            }
            else{
                return false;
            }
        }

        async function viaje_encurso() {
            var michofer = JSON.parse(localStorage.getItem('michofer'))
            var chofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+michofer.telefono)
            var viaje_encurso=await  await axios("{{ setting('admin.url_api')}}viaje_chofer_encurso/"+chofer.data.id)

            return viaje_encurso;
        }

        async function ruta1(myLatLng,map) {
            var michofer = JSON.parse(localStorage.getItem('michofer'))
            var chofer = await axios("{{ setting('admin.url_api') }}chofer/by/"+michofer.telefono)
            var consulta_viaje_disponible= await axios("{{ setting('admin.url_api')}}chofer_viaje_consulta/"+chofer.data.id)

            var data=consulta_viaje_disponible.data.id


            var table= await axios("{{setting('admin.url_api')}}viaje/"+data)

            var destino= await axios("{{setting('admin.url_api')}}ubicacion/"+table.data.origen_location)

            var destinoLatLong= { lat: parseFloat(destino.data.latitud), lng:parseFloat(destino.data.longitud)}
            // var map = new google.maps.Map(document.getElementById("mimapa"), {
            //         center: destinoLatLong,
            //         zoom: 15,
            // });
            var viaje = {
                origin: myLatLng,
                destination: destinoLatLong,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            var directionsDisplay = new google.maps.DirectionsRenderer();
            directionsDisplay.suppressMarkers = true;
            var directionsService = new google.maps.DirectionsService();
            directionsDisplay.setMap(map);

            var marker1 = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                position: destinoLatLong,
                map,
                label: "Cliente"
            });

            directionsService.route(viaje, async function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response)
                    $("#text_distancia").val(response.routes[0].legs[0].distance.text);
                    $("#text_tiempo").val(response.routes[0].legs[0].duration.text);
                }
            });


        }



    </script>

@endsection
