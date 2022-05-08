@extends('master')

@section('css')

@endsection

@section('content')
    <div class="container">

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

                <h5>Formulario Registro Cliente</h5>
                <div class="divider"></div>
                <br>
                <div class="input-field col s6">
                    <label for="firstname">Nombres</label>
                    <input type="text" class="validate" id="firstname" name="firstname" placeholder="Ingrese sus nombres" value="{{ old('firstname') }}" required>
                </div>
                <div class="input-field col s6">
                    <label for="lastname">Apellidos</label>
                    <input type="text" class="validate" id="lastname" name="lastname" placeholder="Ingrese sus apellidos" value="{{ old('lastname') }}" required>
                </div>
                <div class="input-field col s6">
                    <label for="email">Email</label>
                    <input type="email" class="validate" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                </div>

                <div class="input-field col s6">
                    <label for="phone">Teléfono</label>
                    <input type="number" class="validate" id="phone" name="phone" placeholder="Número de Celular" value="{{ old('phone') }}" required>
                </div>

            </div>
            <div class="row">

                <div class="input-field col s12">
                    <select class="browser-default" name="ciudad_id" id="ciudad_select" required></select>
                </div>

            </div>
            <div class="row">

                <div class="file-field input-field">
                    <div class="btn">
                    <input id="imgcliente" name="imgcliente" type="file">
                    <i class="material-icons">photo_library</i>
                    </div>
                    <div class="file-path-wrapper">
                    <input class="file-path validate" name="imgcliente" type="text" placeholder="Foto del Cliente" >
                    </div>
                </div>

            </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Guardar
                <i class="material-icons right">save</i>
            </button>
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
