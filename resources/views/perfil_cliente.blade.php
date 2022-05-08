@extends('master')


@section('content')
    <div class="container-fluid" id="miul" hidden>
        <div class="row">
            <div class="col s12">
                <center>
                    <h4>Mi Perfil</h4>
                    <a style="background-color: #0C2746;" href="#" onclick="salir()" class="waves-effect waves-light btn">Salir</a>
                </center>
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
        $(document).ready(function(){
            $('.modal').modal();
            var miuser = JSON.parse(localStorage.getItem('miuser'))
            if (miuser) {
                M.toast({html: 'Bienvenido! '+miuser.nombres+' '+miuser.apellidos})
                $("#miul").attr('hidden', false)
            } else {
                $('#modal1').modal('open')
            }
        });
        function salir() {
            M.toast({html: 'Vuelve pronto'})
            localStorage.removeItem("miuser")
            location.href= "/welcome"
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
                $("#miul").attr('hidden', false);
            }else{
                M.toast({html : 'Credenciales Invalidas'})
            }
        }
    </script>
@endsection
