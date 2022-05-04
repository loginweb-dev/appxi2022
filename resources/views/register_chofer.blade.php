@extends('master')

@section('css')


@endsection
@section('content')


<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)

                    @if($error=="The categoria id must be an integer.")
                        <span>Categoria y Ciudad son datos necesarios</span>


                        @elseif($error=="The ciudad id must be an integer." )
                        <li>Categoria y Ciudad son datos necesarios</li>

                        @else
                        <li>{{ $error }}</li>

                    @endif

                @endforeach
            </ul>
        </div>

    @endif

    <form action="{{route('registro_chofer')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
    <div class="row">

        <h5>Formulario Registro Conductor(a)</h5>
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
            <input type="email" class="validate" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        </div>

        <div class="input-field col s6">
            <label for="phone">Teléfono</label>
            <input type="number" class="validate" id="phone" name="phone" placeholder="Número de Celular" value="{{ old('phone') }}" required>
        </div>

    </div>
    <div class="row">
        <div class="input-field col s12">
            <select class="browser-default" name="categoria_id" id="categoria_select" required></select>
            {{-- <label>Categoría Vehículo</label> --}}
        </div>

        <div class="input-field col s12">
            <select class="browser-default" name="ciudad_id" id="ciudad_select" required></select>
            {{-- <label>Ciudad</label> --}}
        </div>

    </div>
    <div class="row">

        <div class="file-field input-field">
            <div class="btn">
              {{-- <span>Seleccione Archivo</span> --}}
              <input id="imgchofer" name="imgchofer" type="file" required >
              <i class="material-icons">photo_library</i>
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" name="imgchofer" type="text" placeholder="Foto del Conductor(a)" >
            </div>
        </div>

        <div class="file-field input-field">
            <div class="btn">
                {{-- <span>Seleccione Archivo</span> --}}
                <input id="imgfotosdelvehiculo" name="imgfotosdelvehiculo" type="file" required >
                <i class="material-icons">photo_size_select_actual</i>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" name="imgfotosdelvehiculo" type="text" placeholder="Foto del Vehículo" >
            </div>
        </div>

        <div class="file-field input-field">
            <div class="btn">
                {{-- <span>Seleccione Archivos</span> --}}
                <input id="imgcarnet" name="imgcarnet[]" type="file" multiple required >
                <i class="material-icons">photo_size_select_actual</i>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" name="imgcarnet[]"  type="text" placeholder="Fotos de la Cédula de Identidad" >
            </div>
        </div>


        <div class="file-field input-field">
            <div class="btn">
                {{-- <span>Seleccione Archivos</span> --}}
                <input id="imglicencia" name="imglicencia[]"  type="file" multiple required >
                <i class="material-icons">photo_size_select_actual</i>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" name="imglicencia[]" type="text" placeholder="Fotos de la Licencia de Conducir" >
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
            Categorias();
            Ciudades();
            //console.log("Hola");
        });


        async function Categorias() {
            $('#categoria_select').find('option').remove().end();
            var table = await axios.get("{{ setting('admin.url_api') }}categorias");
            $('#categoria_select').append($('<option>', {
                value: null,
                text: 'Elige una Categoria'
            }));
            for (let index = 0; index < table.data.length; index++) {
                $('#categoria_select').append($('<option>', {
                    value: table.data[index].id,
                    text: table.data[index].name
                }));
            }
        }

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
        // async function ValidarSelect() {
        //     if( $('#categoria_select').val()==undefined){
        //         toastr.alert("Seleccione una Categoria");
        //     }
        //     if( $('#ciudad_select').val()==undefined){
        //         toastr.alert("Seleccione una Ciudad");
        //     }

        // }


    </script>

@endsection
