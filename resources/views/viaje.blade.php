<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{ setting('admin.url').'storage/'.setting('site.logo') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
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
  </head>

  <body>
    <ul class="collapsible popout">
        <li class="active">
            <div class="collapsible-header"><i class="material-icons">place</i>Origen del Viaje</div>
            <div class="collapsible-body">
                <div id="map"></div>
                <input id="latitud" type="text" class="validate">
                <input id="longitud" type="text" class="validate">
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">place</i>Destino del Viaje</div>
            <div class="collapsible-body">
                <div id="map2"></div>
                <input id="latitud2" type="text" class="validate">
                <input id="longitud2" type="text" class="validate">
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">whatshot</i>Detalles del Viaje</div>
            <div class="collapsible-body">
                <div class="row">
                    <div class="input-field col s6">
                      <input placeholder="Placeholder" id="first_name" type="text" class="validate">
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
            navigator.geolocation.getCurrentPosition(initMap, error, options);
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            if (miuser) {
                M.toast({html: 'Bienvenido! '+miuser.nombres+' '+miuser.apellidos})
            } else {
                // $('#modal1').openModal();
                $('#modal1').modal('open');
            }

            initMap2()
        });
        function initMap(pos) {
            var crd = pos.coords
            var radio = pos.accuracy
            var myLatLng = { lat: pos.coords.latitude, lng: pos.coords.longitude }
            map = new google.maps.Map(document.getElementById("map"), {
                center: myLatLng,
                zoom: 14,
            });
            marker = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                draggable: true,
                position: myLatLng,
                map,
                title: "Hola Mundo",
                label: "OR"
            });
            google.maps.event.addListener(marker, 'dragend', function (evt) {
                $("#latitud").val(evt.latLng.lat());
                $("#longitud").val(evt.latLng.lng());
                map.panTo(evt.latLng);
            });
            $("#latitud").val(pos.coords.latitude);
            $("#longitud").val(pos.coords.longitude);
        }

        function initMap2() {
            var myLatLng = { lat: -14.8350387349957, lng: -64.9041263226692 }
            map = new google.maps.Map(document.getElementById("map2"), {
                center: myLatLng,
                zoom: 14,
            });
            marker = new google.maps.Marker({
                animation: google.maps.Animation.DROP,
                draggable: true,
                position: myLatLng,
                map,
                title: "Hola Mundo",
                label: "DE"
            });
            google.maps.event.addListener(marker, 'dragend', function (evt) {
                $("#latitud2").val(evt.latLng.lat());
                $("#longitud2").val(evt.latLng.lng());
                map.panTo(evt.latLng);
            });
            $("#latitud2").val(myLatLng.lat);
            $("#longitud2").val(myLatLng.lng);
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
    </script>
  </body>
</html>
