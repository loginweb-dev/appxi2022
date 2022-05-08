<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landingpage');
});

Route::get('/privacidad', function () {
    return view('privacidad');
});

Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('perfil/cliente', function () {
    return view('perfil_cliente');
});

Route::get('viaje/crear', function () {
    return view('viajes');
})->name('viaje_crear');

Route::get('chofer/crear', function () {
    return view('register_chofer');
});

Route::get('cliente/crear', function () {
    return view('register_cliente');
});

Route::get('viaje/{id}', function ($id) {
    return view('viaje', compact('id'));
})->name('viaje');

Route::get('misviajes', function () {
    return view('misviajes');
})->name('misviaje');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('viajes/monitor', function () {
    return view('viajes_monitor');
})->name('viajes_monitor');

Route::post('chofer/nuevo', function  (Request $request) {

    $validated = $request->validate([
        'categoria_id' => 'required|integer'
    ]);
    $validated = $request->validate([
        'ciudad_id' => 'required'
    ]);


    $perfil = $request->file('imgchofer');
    $newperfil =  Storage::disk('public')->put('choferes', $perfil);

    $ci= $request->file('imgcarnet');
    $newcarnet=[];
    $indexcarnet=0;
    foreach($ci as $item){
        $newcarnet[$indexcarnet]=Storage::disk('public')->put('choferes', $item);
        $indexcarnet=$indexcarnet+1;
    }


    $licencia= $request->file('imglicencia');
    $newlicencia=[];
    $indexlicencia=0;
    foreach($licencia as $item){
        $newlicencia[$indexlicencia]=Storage::disk('public')->put('choferes', $item);
        $indexlicencia=$indexlicencia+1;
    }


    $vehiculo= $request->file('imgfotosdelvehiculo');
    $newvehiculo=Storage::disk('public')->put('choferes', $vehiculo);


    $chofer= App\Chofere::create([
        'nombres'=> $request->firstname,
        'apellidos'=> $request->lastname,
        'email'=>$request->email,
        'telefono'=> $request->phone,
        'ciudad_id'=> $request->ciudad_id,
        'perfil'=> $newperfil,
        'breve'=> json_encode($newlicencia),
        'vehiculo'=> $newvehiculo,
        'carnet'=>json_encode($newcarnet),
        'estado'=>1,
        'categoria_id'=>$request->categoria_id,
        'estado_verificacion'=>0,
        'creditos'=>0


    ]);


return view('welcome_chofer', compact('chofer'));

})->name('registro_chofer');


Route::post('chofer_update', function  (Request $request) {

    $validated = $request->validate([
        'categoria_id' => 'required|integer'
    ]);
    $validated = $request->validate([
        'ciudad_id' => 'required'
    ]);

    $perfil = $request->file('imgchofer');
    $newperfil =  Storage::disk('public')->put('choferes', $perfil);

    $ci= $request->file('imgcarnet');
    $newcarnet=[];
    $indexcarnet=0;
    foreach($ci as $item){
        $newcarnet[$indexcarnet]=Storage::disk('public')->put('choferes', $item);
        $indexcarnet=$indexcarnet+1;
    }


    $licencia= $request->file('imglicencia');
    $newlicencia=[];
    $indexlicencia=0;
    foreach($licencia as $item){
        $newlicencia[$indexlicencia]=Storage::disk('public')->put('choferes', $item);
        $indexlicencia=$indexlicencia+1;
    }


    $vehiculo= $request->file('imgfotosdelvehiculo');
    $newvehiculo=Storage::disk('public')->put('choferes', $vehiculo);


})->name('update_chofer');


Route::post('cliente/nuevo', function  (Request $request) {

    $validated = $request->validate([
        'ciudad_id' => 'required'
    ]);

    $perfil = $request->file('imgcliente');
    $newperfil = null;
    if ($perfil) {
        $newperfil =  Storage::disk('public')->put('clientes', $perfil);
    }



    $cliente= App\Cliente::create([
        'nombres'=> $request->firstname,
        'apellidos'=> $request->lastname,
        'telefono'=> $request->phone,
        'ciudad_id'=> $request->ciudad_id,
        'perfil'=> $newperfil ? $newperfil : null,

    ]);



    return view('welcome_cliente', compact('cliente'));
})->name('registro_cliente');

Route::get('welcomes/chofer', function () {
    return view('welcome_chofer');
});

Route::get('perfil/chofer', function () {
    return view('perfil_chofer');
});

Route::get('historial/chofer', function () {
    return view('historial_viajes_chofer');
});

Route::get('historial/cliente', function () {
    return view('historial_viajes_cliente');
});

Route::get('soporte', function () {
    return view('soporte');
});

Route::get('creditos/chofer', function () {
    return view('creditos_chofer');
});

Route::get('notificacion/banipay', function () {
    return view('notificacion_banipay');
});
