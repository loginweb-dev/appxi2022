<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="icon" type="image/x-icon" href="{{ setting('admin.url').'storage/'.setting('site.logo') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
        #map2 {
            width: 100%;
            height: 400px;
        }
    </style>
  </head>

  <body>
    <ul class="collapsible popout">
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
                                    <input name="group1" type="radio" value="{{ $item->id }}" />
                                    <span>{{ $item->name }}</span>
                                </label>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                <div class="collapsible-body">
                    <div id="map"></div>
                    <input id="latitud" type="text" class="validate" hidden>
                    <input id="longitud" type="text" class="validate" hidden>
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="distancia">Detalle</label>
                            <input id="detalle_origen" type="text" class="validate">
                        </div>
                        <div class="input-field col s6">
                            {{-- <label for="distancia">Tiempo</label> --}}
                            <a href="#" class="waves-effect waves-light btn" onclick="save_origen()">Siguiente</a>
                        </div>
                    </div>
                </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">place</i>Destino del Viaje</div>

            <div class="collapsible-body">
                <div id="map2"></div>
                <input id="latitud2" type="text" class="validate" hidden>
                <input id="longitud2" type="text" class="validate" hidden>
                <div class="row">


                    <div class="input-field col s6">
                        <label for="distancia">Distancia</label>
                        <input id="distancia" type="text" class="validate" readonly>
                    </div>
                    <div class="input-field col s6">
                        <label for="distancia">Tiempo</label>
                        <input id="tiempo" type="text" class="validate" readonly>
                    </div>

                    <div class="input-field col s6">
                        <label for="text_start">Origen</label>
                        <input id="text_start" type="text" class="validate" readonly>
                    </div>
                    <div class="input-field col s6">

                        <input id="text_end" type="text" class="validate" readonly>
                        <label for="text_end">Destino</label>
                    </div>

                    <div class="input-field col s6">
                        <input id="precio_aprox" type="number" class="validate" value="10" readonly>
                        <label for="precio_aprox">Precio Aprox</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="precio_ofertado" type="number" class="validate">
                        <label for="precio_ofertado">Precio Ofertado</label>
                    </div>

                    <div class="input-field col s6">
                        <label for="distancia">Detalle</label>
                        <input id="detalle_destino" type="text" class="validate">
                    </div>
                    <div class="input-field col s6">
                        {{-- <label for="distancia">Detalle</label> --}}
                        <a href="#" class="waves-effect waves-light btn" onclick="save_destino()">Siguiente</a>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">whatshot</i>Detalles del Viaje</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s6">
                      <input id="first_name" type="text" class="validate">
                      <label for="first_name">First Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" type="text" class="validate">
                        <label for="last_name">Last Name</label>
                      </div>
                </div>
            </div>
        </li>
    </ul>
    {{-- <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Modal</a> --}}

    <!-- Modal Structure -->
    <div id="modal1" class="modal bottom-sheet">
        <div class="modal-content">
        <h4>Cual es tu Telefono ?</h4>
        {{-- <p>Trinidad - Beni</p> --}}
        <input placeholder="Ingresa tu telefono - 8 digitos" id="telefono" type="number" class="validate">
        </div>
        <div class="modal-footer">
            {{-- <h4>Cual es tu Ciudad ?</h4> --}}
            <a href="#!" onclick="set_ciudad()" class="modal-close waves-effect waves-light btn">Trinidad - Beni</a>
            {{-- <a href="#!" onclick="set_ciudad()" class="modal-close waves-effect waves-green btn-flat">Riberalta - Beni</a> --}}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBacu367x_GAuwEOzKrjbQSyYqHCwWJpsc&v=weekly" defer></script>
    <script>
        $('document').ready(function () {
            $('.collapsible').collapsible();
            $('.modal').modal();
            var options = {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            };

            navigator.geolocation.getCurrentPosition(set_origen, error, options);
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            if (miuser) {
                M.toast({html: 'Bienvenido! '+miuser.nombres+' '+miuser.apellidos})
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
            if (detalle_1 == '') {
                M.toast({html : 'Ingresa una descripcion a tu ubicacion de origen'})
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
                zoom: 16,
            });
            google.maps.event.addListener(map2, 'click', newmarker);
        }

        function newmarker(event) {
            console.log(event.LatLng.lat())
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
            directionsService.route(viaje, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response)
                    $("#distancia").val(response.routes[0].legs[0].distance.value)
                    $("#tiempo").val(response.routes[0].legs[0].duration.value)
                    $("#text_start").val(response.routes[0].legs[0].start_address)
                    $("#text_end").val(response.routes[0].legs[0].end_address)
                    var dikm = response.routes[0].legs[0].distance.value / 1000
                    var taprox = response.routes[0].legs[0].duration.value / 60
                    // var papro = calcular_precio_estimado(1, 1, '11:22', taprox, dikm)
                    // $("#precio_aprox").val(papro)

                    // var destino = {latitud: event, longitud: lng_1, detalle: event}
                    // localStorage.setItem('origen', JSON.stringify(origen))
                }
            });
        }

        function error(err) {
            alert(err.message)
            console.warn('ERROR(' + err.code + '): ' + err.message)
        };

        async function set_ciudad() {
            var telefono =  $('#telefono').val()
            var micliente = await axios.get("{{ setting('admin.url_api') }}cliente/by/"+telefono)
            localStorage.setItem('miuser', JSON.stringify(micliente.data));
        }

        async function calcular_precio_estimado(categoria_id, ciudad, hora_actual, tiempo_estimado, distancia_estimada){
            var precio=0;
            var city= await axios("setting('admin.url_api')/ciudad/"+ciudad);
            switch(categoria_id){
                case'1':
                    if(CalculoHorasRestantes(city.data.horario_noche,tiempo_estimado)=="normal"){
                        precio= city.data.tarifa_base_dia_moto+(city.data.costo_minuto_moto*tiempo_estimado)+(city.data.costo_kilometro_moto*distancia_estimada);
                    }
                    else{
                        precio= city.data.tarifa_base_noche_moto+(city.data.costo_minuto_moto*tiempo_estimado)+(city.data.costo_kilometro_moto*distancia_estimada);
                    }
                break;
                case'2':
                    if(CalculoHorasRestantes(city.data.horario_noche,tiempo_estimado)=="normal"){
                        precio=city.data.tarifa_base_dia_auto+(city.data.costo_minuto_auto*tiempo_estimado)+(city.data.costo_kilometro_auto*distancia_estimada);
                    }
                    else{
                        precio=city.data.tarifa_base_noche_auto+(city.data.costo_minuto_auto*tiempo_estimado)+(city.data.costo_kilometro_auto*distancia_estimada);
                    }
                break;
            }
            return precio;
        }

        function CalculoHorasRestantes(hora_ci, tiempo_estimado){
            var horario="";
            var text="Si existe un aumento en la estimación del precio en horario normal, es debido a que la hora de llegada será en horario noche";
            var today=new Date();

            var hora_inicio_horas=today.getHours();
            var hora_inicio_minutos =   today.getMinutes();

            //var strTime = hora_inicio_horas + ':' + hora_inicio_minutos;
            var aux= recalcularHoras(hora_inicio_horas,hora_inicio_minutos,tiempo_estimado);
            var strTime =aux;

            if(hora_ci>strTime){
                //console.log("Es temprano");
                horario="normal";
            }
            if(hora_ci<=strTime){
                //console.log("Es tarde");
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




        function save_destino() {

        }
    </script>
  </body>
</html>
