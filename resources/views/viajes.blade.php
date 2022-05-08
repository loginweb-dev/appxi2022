@extends('master')

@section('css')
    <style>
    #map {
        width: 100%;
        height: 350px;
    }
    #map2 {
        width: 100%;
        height: 350px;
    }
    </style>
@endsection

@section('content')
    <ul class="collapsible popout" id="miul" hidden>
        <li class="active">
            <div class="collapsible-header"><i class="material-icons">place</i>Origen y Tipo de Viaje</div>
            <table class="responsive-table">
                <tbody>
                    @php
                        $categorias = App\Categoria::all();
                    @endphp
                    @foreach ($categorias as $item)
                        <tr>
                            <td>
                                <label>
                                    <img src="{{ setting('admin.url_storage').'/'.$item->logo }}" alt="" class="responsive-img circle" width="80">
                                        <br>
                                    <input style="background-color: #0C2746;" name="group1" type="radio" value="{{ $item->id }}" />
                                    <span>{{ $item->name }}</span>
                                </label>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                <div class="collapsible-body">
                    <center>
                        <p>Mueve el marcador para mejorar tu ubicacion</p>
                    </center>
                    <div id="map"></div>
                    <input id="latitud" type="text" class="validate" hidden>
                    <input id="longitud" type="text" class="validate" hidden>
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="detalle_origen">Detalle de tu ubicacion</label>
                            <input id="detalle_origen" type="text" class="validate">
                        </div>
                        <div class="input-field col s4">
                            <a style="background-color: #0C2746;" class="waves-effect waves-light btn" onclick="save_origen()">Siguiente</a>
                        </div>
                    </div>
                </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">place</i>Destino del Viaje</div>

            <div class="collapsible-body">
                <center>
                    <p>Dale click en el mapa para establecer tu ubicacion de destino.</p>
                </center>
                <div id="map2"></div>
                <input id="latitud2" type="text" class="validate" hidden>
                <input id="longitud2" type="text" class="validate" hidden>
                <div class="row">
                    <div class="input-field col s6">
                        <label for="distancia">Distancia</label>
                        <input placeholder="" id="distancia" type="text" class="validate" readonly>
                    </div>
                    <div class="input-field col s6">
                        <label for="distancia">Tiempo</label>
                        <input placeholder="" id="tiempo" type="text" class="validate" readonly>
                    </div>
                    <div class="input-field col s6">
                        <label for="text_start">Origen</label>
                        <input placeholder="" id="text_start" type="text" class="validate" readonly>
                    </div>
                    <div class="input-field col s6">
                        <label for="text_end">Destino</label>
                        <input  placeholder="" id="text_end" type="text" class="validate" readonly>
                    </div>
                    <div class="input-field col s6">
                        <label for="precio_aprox">Precio Aprox</label>
                        <input placeholder="" id="precio_aprox" type="number" class="validate" value="10" readonly>
                    </div>
                    <div class="input-field col s6">
                        <input id="precio_ofertado" type="number" class="validate">
                        <label for="precio_ofertado">Precio Ofertado</label>
                    </div>

                    <div class="input-field col s8">
                        <label for="detalle_destino">Detalle de tu destino</label>
                        <input id="detalle_destino" type="text" class="validate">
                    </div>
                    <div class="input-field col s4">
                        <a style="background-color: #0C2746;" class="waves-effect waves-light btn" onclick="save_destino()">Siguiente</a>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">whatshot</i>Detalles del Viaje</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s6">
                        <input placeholder="" id="nombres" type="text" class="validate" readonly>
                        <label for="nombres">Nombres</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="" id="apellidos" type="text" class="validate" readonly>
                        <label for="apellidos">Apellidos</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="p_aprox" type="text" class="validate" readonly>
                        <label for="p_aprox">Precio Aprox</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="" id="p_ofertado" type="text" class="validate" readonly>
                        <label for="p_ofertado">Precio Ofertado</label>
                    </div>
                    <div class="input-field col s6">
                        <input placeholder="" id="detalle1" type="text" class="validate" readonly>
                        <label for="detalle1">Detalle Origen</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="detalle2" type="text" class="validate" readonly>
                        <label for="detalle2">Detalle Destino</label>
                    </div>
                    <div class="col s12">
                        <center>
                            <a style="background-color: #0C2746;" href="#" class="waves-effect waves-light btn pulse" onclick="save_viaje()"><i class="material-icons">edit</i> Enviar Solicitud</a>
                        </center>
                    </div>

                </div>
            </div>
        </li>
    </ul>
    <div id="modal1" class="modal bottom-sheet">
        <div class="modal-content">
            <h5>Cual es tu Telefono</h5>
            <div class="row">
                <div class="col s9">
                    <input placeholder="Ingresa tu telefono - 8 digitos" id="telefono" type="number" class="validate">
                </div>
                <div class="col s3">
                    <a style="background-color: #0C2746;"  id="btn_telefono" href="#" onclick="get_cliente()" class="waves-effect waves-light btn"><i class="material-icons">search</i></a>
                </div>
            </div>
            <div class="row">
                <div class="col s9">
                    <input placeholder="PIN - 4 digitos" id="pin" type="number" class="validate" disabled>
                </div>
                <div class="col s3">
                    <a style="background-color: #0C2746;" id="btn_pin" href="#" onclick="get_pin()" class="waves-effect waves-light btn" disabled><i class="material-icons">key</i></a>
                </div>
            </div>
        </div>
    </div>
@endsection

    @section('javascript')
    <script>

        $('document').ready(function () {
            $('.collapsible').collapsible();
            $('.modal').modal();
            $('select').formSelect();
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            if (miuser) {
                M.toast({html: 'Bienvenido! '+miuser.nombres+' '+miuser.apellidos})
                var options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                $("#miul").attr('hidden', false);
                navigator.geolocation.getCurrentPosition(set_origen, error, options);
            } else {
                $('#modal1').modal('open');
            }
        });

        $('input[type=radio][name=group1]').change(async function() {
            var categoria = await axios.get("{{ setting('admin.url_api') }}categoria/"+this.value)
            localStorage.setItem('micategoria', JSON.stringify(categoria.data));
        });

        function initMap(pos) {
            var crd = pos.coords
            var radio = pos.accuracy
            myLatLng = { lat: pos.coords.latitude, lng: pos.coords.longitude }
            map = new google.maps.Map(document.getElementById("map"), {
                center: myLatLng,
                zoom: 11,
            });
            // var marker1 = new google.maps.Marker({
            //     animation: google.maps.Animation.DROP,
            //     draggable: true,
            //     position: myLatLng,
            //     map,
            //     label: "OR"
            // });
            // google.maps.event.addListener(marker1, 'dragend', function (evt) {
            //     $("#latitud").val(evt.latLng.lat());
            //     $("#longitud").val(evt.latLng.lng());
            //     map.panTo(evt.latLng);
            // });
            // $("#latitud").val(pos.coords.latitude);
            // $("#longitud").val(pos.coords.longitude);

            // // 2 marker
            var myLatLng2 = { lat: -14.8350387349957, lng: -64.9041263226692 }
            // var marker2 = new google.maps.Marker({
            //     animation: google.maps.Animation.DROP,
            //     draggable: true,
            //     position: myLatLng2,
            //     map,
            //     label: "DE"
            // });
            // google.maps.event.addListener(marker2, 'dragend', function (evt) {
            //     // $("#latitud").val(evt.latLng.lat());
            //     // $("#longitud").val(evt.latLng.lng());
            //     map.panTo(evt.latLng);
            // });


            // direccion
            // directionsService = new google.maps.DirectionsService();
            directionsDisplay = new google.maps.DirectionsRenderer();
            directionsService = new google.maps.DirectionsService();
            directionsDisplay.setMap(map);

            // var start = '37.7683909618184, -122.51089453697205';
            // var end = '41.850033, -87.6500523';
            var viaje = {
                origin:myLatLng,
                destination:myLatLng2,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };

            directionsService.route(viaje, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                    var myRoute = response.routes[0];
                    // var txtDir = '';
                    // for (var i=0; i<myRoute.legs[0].steps.length; i++) {
                    // txtDir += myRoute.legs[0].steps[i].instructions+"<br />";
                    // }
                    // document.getElementById('directions').innerHTML = txtDir;
                    console.log(response.routes[0].legs[0].distance.text)
                    console.log(response.routes[0].legs[0].duration.text)
                    console.log(myRoute)
                    $("#distancia").val(response.routes[0].legs[0].distance.text);
                    $("#tiempo").val(response.routes[0].legs[0].duration.text);
                    $("#text_start").val(response.routes[0].legs[0].start_address);
                    $("#text_end").val(response.routes[0].legs[0].end_address);
                    console.log(response.routes[0].legs[0].start_address)
                    console.log(response.routes[0].legs[0].end_address)
                    map.setCenter(new google.maps.LatLng(myLatLng.lat, myLatLng.lng));
                }
            });
            // const center = new google.maps.LatLng(myLatLng.lat, myLatLng.lng);
            map.setCenter(new google.maps.LatLng(myLatLng.lat, myLatLng.lng));

            google.maps.event.addListener(map, 'click', newmarker);
        }

        function set_origen(pos) {
            var crd = pos.coords
            var radio = pos.accuracy
            var myLatLng = { lat: pos.coords.latitude, lng: pos.coords.longitude }
            var map = new google.maps.Map(document.getElementById("map"), {
                center: myLatLng,
                zoom: 13,
            });
            var marker1 = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                draggable: true,
                position: myLatLng,
                map,
                label: "OR"
            });
            google.maps.event.addListener(marker1, 'dragend', function (evt) {
                $("#latitud").val(evt.latLng.lat());
                $("#longitud").val(evt.latLng.lng());
                map.panTo(evt.latLng);
            });
            $("#latitud").val(pos.coords.latitude);
            $("#longitud").val(pos.coords.longitude);
        }

        function save_origen() {
            var lat_1 = $('#latitud').val()
            var lng_1 = $('#longitud').val()
            var detalle_1 = $('#detalle_origen').val()
            var micategoria = $("input[type=radio][name=group1]:checked").val()
            if (detalle_1 == '' || micategoria == null) {
                $("#detalle_origen").focus();
                M.toast({html : 'Ingresa una descripcion a tu ubicacion de origen o Categoria'})
            } else {
                var origen = {latitud: lat_1, longitud: lng_1, detalle: detalle_1}
                localStorage.setItem('origen', JSON.stringify(origen))
                var instance = M.Collapsible.getInstance($('.collapsible').collapsible())
                instance.open(1)
                set_destino()
                $("#distancia").val('')
                $("#tiempo").val('')
                $("#text_start").val('')
                $("#text_end").val('')
                $("#precio_aprox").val('')
                $("#precio_ofertado").val('')
            }
        }

        var map2;
        function set_destino() {
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            var myLatLng2 = { lat: parseFloat(miuser.ciudad.latitud), lng: parseFloat(miuser.ciudad.longitud) }
            map2 = new google.maps.Map(document.getElementById("map2"), {
                center: myLatLng2,
                zoom: 14,
            });
            google.maps.event.addListener(map2, 'click', newmarker);
        }

        function newmarker(event) {
            var micategoria = JSON.parse(localStorage.getItem('micategoria'))
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            var origen = JSON.parse(localStorage.getItem('origen'))
            var myLatLng = { lat: parseFloat(origen.latitud), lng: parseFloat(origen.longitud) }
            var viaje = {
                origin: myLatLng,
                destination: event.latLng,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            var directionsDisplay = new google.maps.DirectionsRenderer();
            directionsDisplay.suppressMarkers = true;
            var directionsService = new google.maps.DirectionsService();
            directionsDisplay.setMap(map2);
            directionsService.route(viaje, async function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response)
                    $("#distancia").val(response.routes[0].legs[0].distance.text)
                    $("#tiempo").val(response.routes[0].legs[0].duration.text)
                    $("#text_start").val(response.routes[0].legs[0].start_address)
                    $("#text_end").val(response.routes[0].legs[0].end_address)
                    var dikm = response.routes[0].legs[0].distance.value / 1000
                    var taprox = response.routes[0].legs[0].duration.value / 60
                    var papro = await calcular_precio_estimado(micategoria.id, miuser.ciudad.id, taprox, dikm)
                    $("#precio_aprox").val(papro)
                    var destino = { latitud: event.latLng.lat(), longitud: event.latLng.lng(), precio_aprox: papro, precio_ofertado: null, tiempo: taprox, distancia: dikm, detalle: null}
                    localStorage.setItem('destino', JSON.stringify(destino))
                }
            });
        }

        function error(err) {
            alert(err.message+" - Habilita tu Sensor GPS")
            console.warn('ERROR(' + err.code + '): ' + err.message)
        };

        async function set_ciudad() {
            var telefono =  $('#telefono').val()
            var ciudad_id =  $('#ciudad_id').val()
            var nombres =  $('#ciudad_id').val()
            var apellidos =  $('#apellidos').val()
            var midata = { telefono: telefono, ciudad_id: ciudad_id, nombres: nombres, apellidos: apellidos }
            var micliente = await axios.get("{{ setting('admin.url_api') }}cliente/by/"+JSON.stringify(midata))
            localStorage.setItem('miuser', JSON.stringify(micliente.data));
            M.toast({ html: 'Bienvenido: '+micliente.data.nombres+' '+micliente.data.apellidos })
        }

        async function calcular_precio_estimado(categoria_id, ciudad, tiempo_estimado, distancia_estimada){
            var precio=0;
            var city = await axios("{{setting('admin.url_api')}}ciudad/"+ciudad);
            switch(categoria_id){
                case 1:
                    if(CalculoHorasRestantes(city.data.horario_noche,tiempo_estimado)=="normal"){
                        precio= city.data.tarifa_base_dia_moto+(city.data.costo_minuto_moto*tiempo_estimado)+(city.data.costo_kilometro_moto*distancia_estimada);
                    }
                    else{
                        precio= city.data.tarifa_base_noche_moto+(city.data.costo_minuto_moto*tiempo_estimado)+(city.data.costo_kilometro_moto*distancia_estimada);
                    }
                break;
                case 2:
                    if(CalculoHorasRestantes(city.data.horario_noche,tiempo_estimado)=="normal"){
                        precio=city.data.tarifa_base_dia_auto+(city.data.costo_minuto_auto*tiempo_estimado)+(city.data.costo_kilometro_auto*distancia_estimada);
                    }
                    else{
                        precio=city.data.tarifa_base_noche_auto+(city.data.costo_minuto_auto*tiempo_estimado)+(city.data.costo_kilometro_auto*distancia_estimada);
                    }
                break;
            }
            return parseFloat(precio).toFixed(2);
        }

        function CalculoHorasRestantes(hora_ci, tiempo_estimado){
            var horario="";
            var text="Si existe un aumento en la estimación del precio en horario normal, es debido a que la hora de llegada será en horario noche";
            var today=new Date();
            var hora_inicio_horas=today.getHours();
            var hora_inicio_minutos =   today.getMinutes();
            var aux= recalcularHoras(hora_inicio_horas,hora_inicio_minutos,tiempo_estimado);
            var strTime =aux;
            if(hora_ci>strTime){
                horario="normal";
            }
            if(hora_ci<=strTime){
                horario="noche";
            }
            return horario;
        }

        function recalcularHoras(horas, minutos, tiempo_estimado){
            var strTime=0;
            var aux_hora=0;
            var aux_minutos=0;
            if((minutos+tiempo_estimado)>60){
                var div_entera_parahoras=Math.floor((minutos+tiempo_estimado)/60);
                var div_entera_paraminutos=(minutos+tiempo_estimado)%60;
                aux_hora=horas+div_entera_parahoras;
                aux_minutos= div_entera_paraminutos;
                strTime= aux_hora+ ':' +aux_minutos;
            }
            else{
                aux_minutos=minutos+tiempo_estimado;
                strTime= horas+ ':' +aux_minutos;
            }
            return strTime;
        }

        async function save_destino() {
            var origen = JSON.parse(localStorage.getItem('origen'))
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            var destino = JSON.parse(localStorage.getItem('destino'))
            var detalle_2 = $("#detalle_destino").val()
            var precio_ofertado = $("#precio_ofertado").val()
            var newdestino = {latitud: destino.latitud, longitud: destino.longitud, precio_aprox: destino.precio_aprox, precio_ofertado: precio_ofertado, detalle: detalle_2, tiempo: destino.tiempo, distancia: destino.distancia }
            localStorage.setItem('destino', JSON.stringify(newdestino))

            if (detalle_2 != '') {
                var newdestino = JSON.parse(localStorage.getItem('destino'))
                $("#nombres").val(miuser.nombres)
                $("#apellidos").val(miuser.apellidos)
                $("#p_aprox").val(newdestino.precio_aprox)
                $("#p_ofertado").val(newdestino.precio_ofertado)
                $("#detalle1").val(origen.detalle)
                $("#detalle2").val(newdestino.detalle)
                var instance = M.Collapsible.getInstance($('.collapsible').collapsible())
                instance.open(2)
            }else{
                $("#precio_ofertado").focus();
                M.toast({html : 'Ingresa una descripcion a tu destino y un precio a ofertar'})
            }
        }

        async function save_viaje() {
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            var micategoria = JSON.parse(localStorage.getItem('micategoria'))
            var origen = JSON.parse(localStorage.getItem('origen'))
            var destino = JSON.parse(localStorage.getItem('destino'))

            var neworigen = await axios("{{setting('admin.url_api')}}location/save/"+JSON.stringify({ latitud: origen.latitud, longitud: origen.longitud, detalle: origen.detalle }))
            var newdestino = await axios("{{setting('admin.url_api')}}location/save/"+JSON.stringify({ latitud: destino.latitud, longitud: destino.longitud, detalle: destino.detalle }))

            var newviaje = {
                'cliente_id': miuser.id,
                'origen_location': neworigen.data.id,
                'destino_location': newdestino.data.id,
                'categoria_id': micategoria.id,
                'precio_inicial': destino.precio_ofertado,
                'tiempo': destino.tiempo,
                'distancia': destino.distancia,
                'ciudad_id': miuser.ciudad.id
            }
            var viaje = await axios("{{setting('admin.url_api')}}viaje/save/"+JSON.stringify(newviaje))
            localStorage.setItem('viaje', JSON.stringify(viaje.data))
            var mensaje="Hola, gracias por tu preferencia, APPXI esta buscando un taxi ideal para ti, espera una notificacion por whatsapp cuando este listo tu taxi."
            var wpp= await axios("https://chatbot.appxi.net/?type=text&phone="+miuser.telefono+"&message="+mensaje)
            var miscoket = await socket.emit('nuevo_viaje', mensaje)
            localStorage.removeItem('micategoria');
            localStorage.removeItem('origen');
            localStorage.removeItem('destino');
            location.href = "/viaje/"+viaje.data.id
        }

        async function get_cliente() {
            var telefono = $("#telefono").val()
            if (telefono == '') {
                M.toast({html : 'Ingresa un telefono valido'})
            } else {
                var miuser = await axios("{{ setting('admin.url_api') }}cliente/by/"+telefono)
                if (miuser.data) {
                    var pin = Math.floor(1000 + Math.random() * 9000);
                    var cliente = await axios("{{ setting('admin.url_api') }}pin/save/"+miuser.data.id+"/"+pin)
                    var mensaje="Hola, tu pin para acceder a APPXI es: "+pin
                    var wpp= await axios("https://chatbot.appxi.net/?type=text&phone="+telefono+"&message="+mensaje)
                    M.toast({html : 'Revisa tu Whatsapp'})
                    $("#telefono").attr('disabled', true);
                    $("#btn_telefono").attr('disabled', true);
                    $("#pin").attr('disabled', false);
                    $("#btn_pin").attr('disabled', false);
                } else {
                    location.href= '/cliente/crear'
                }
            }
        }
        async function get_pin() {
            var pin = $("#pin").val()
            var telefono = $("#telefono").val()
            var miuser = await axios("{{ setting('admin.url_api') }}pin/get/"+telefono+"/"+pin)
            if (miuser.data) {
                localStorage.setItem('miuser', JSON.stringify(miuser.data))
                $('#modal1').modal('close')
                M.toast({html : 'Bienvenido'})
                var options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                $("#miul").attr('hidden', false);
                navigator.geolocation.getCurrentPosition(set_origen, error, options);
            }else{
                M.toast({html : 'Credenciales Invalidas'})
            }
        }
    </script>
    @endsection
