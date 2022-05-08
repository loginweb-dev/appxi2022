@extends('master')

@section('css')

@endsection

@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)

                        @if($error=="The ciudad id must be an integer." )
                        <li>La Ciudad es un dato necesario necesario</li>

                        @else
                        <li>{{ $error }}</li>

                        @endif

                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('registro_cliente')}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col s12">
                    <center>
                        <h4>Nuevo Pasajero</h4>
                    </center>
                    <br>
                    <div class="input-field">
                        <label for="phone">Teléfono (*)</label>
                        <input type="number" class="validate" id="phone" name="phone" placeholder="Número de Celular" value="{{ old('phone') }}" required>
                    </div>
                    <div class="input-field">
                        <label for="firstname">Nombres (*)</label>
                        <input type="text" class="validate" id="firstname" name="firstname" placeholder="Ingrese tu nombre" value="{{ old('firstname') }}" required>
                    </div>
                    <div class="input-field">
                        <label for="lastname">Apellidos (*)</label>
                        <input type="text" class="validate" id="lastname" name="lastname" placeholder="Ingrese tu apellido" value="{{ old('lastname') }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <label for="lastname">Localidad (*)</label>
                    <select class="browser-default" name="ciudad_id" id="ciudad_select" required></select>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="file-field input-field">
                        <div class="btn">
                        <input id="imgcliente" name="imgcliente" type="file">
                        <i class="material-icons">photo_library</i>
                        </div>
                        <div class="file-path-wrapper">
                        <input class="file-path validate" name="imgcliente" type="text" placeholder="Selfy">
                        </div>
                    </div>
                </div>
            </div>
            <center>
                <button id="btn_enviar" style="background-color: #0C2746;" class="btn waves-effect waves-light" type="submit" name="action">Enviar a Verificacion
                </button>
            </center>

        </form>
    </div>
@endsection

@section('javascript')

    <script>
         $('document').ready(function () {
            $('select').formSelect();
            Ciudades();
        });

        async function Ciudades() {
            $('#ciudad_select').find('option').remove().end();
            var table = await axios.get("{{setting('admin.url_api')}}ciudades");
            $('#ciudad_select').append($('<option>', {
                value: null,
                text: 'Elige una Ciudad'
            }));
            for (let index = 0; index < table.data.length; index++) {
                $('#ciudad_select').append($('<option>', {
                    value: table.data[index].id,
                    text: table.data[index].name
                }));
            }
        }

    </script>

@endsection
