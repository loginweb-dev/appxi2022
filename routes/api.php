<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Categoria;
use App\Chofere;
use App\Ciudade;
use App\Cliente;
use App\Estado;
use App\Objeto;
use App\Pasarela;
use App\Ubicacione;
use App\Viaje;
use App\Notificacione;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('cliente/by/{telefono}', function ($telefono) {
    // $midata2=json_decode($midata);
    return Cliente::where('telefono', $telefono)->with('ciudad')->first();
    // if ($cliente) {
    //     return $cliente;
    // } else {
    //     $newcliente = App\Cliente::create([
    //         'telefono' => $midata2->telefono,
    //         'ciudad_id' => $midata2->ciudad_id,
    //         'nombres' => $midata2->nombres,
    //         'apellidos' => $midata2->apelldos
    //     ]);
    //     return $newcliente;
    // }
});

// TODOS LOS OBJETOS DEL VIAJE
Route::get('objetos', function(){
    return Objeto::all();
});
//BUSCAR OBJETO POR CRITERIO
Route::get('objeto_individual/{criterio}', function($criterio){
    $objeto= Objeto::where('name', 'like', '%'.$criterio.'%')->orderBy('name', 'desc')->get();
    return $objeto;
});
//TODOS LOS CLIENTES
Route::get('clientes', function(){
    return Cliente::all();
});
//CLIENTE POR ID
Route::get('cliente_por_id/{id}', function($id){
    return Cliente::find($id);
});
//BUSCAR CLIENTE POR CRITERIO
Route::get('cliente/name/{criterio}', function($criterio){
    $cliente= Cliente::where('name', 'like', '%'.$criterio.'%')->orderBy('name', 'desc')->get();
});
//TODOS LOS CHOFERES
Route::get('chofer/by/{telefono}', function($telefono){
    return Chofere::where('telefono', $telefono)->with('ciudad')->first();
});

Route::get('choferes', function(){
    return Chofere::all();
});

//CHOFER POR ID
Route::get('chofer_por_id/{id}', function($id){
    return Chofere::find($id);
});
//BUSCAR CHOFER POR CRITERIO
Route::get('chofer/name/{criterio}', function($criterio){
    $cliente= Chofere::where('name', 'like', '%'.$criterio.'%')->orderBy('name', 'desc')->get();
});
//TODAS LAS CIUDADES
Route::get('ciudades', function(){
    return Ciudade::all();
});
//CIUDAD POR ID
Route::get('ciudad/{id}', function($id){
    return Ciudade::find($id);
});
//TODAS LAS CATEGORIAS
Route::get('categorias', function(){
    return Categoria::all();
});
//CATEGORIA POR ID
Route::get('categoria/{id}', function($id){
    return Categoria::find($id);
});
//TODAS LOS ESTADOS
Route::get('estados', function(){
    return Estado::all();
});
//ESTADOS POR ID
Route::get('estado/{id}', function($id){
    return Estado::find($id);
});
//TODAS LAS PASARELAS
Route::get('pararelas', function(){
    return Pasarela::all();
});
//PASARELA POR ID
Route::get('pasarela/{id}', function($id){
    return Pasarela::find($id);
});
//TODAS LAS UBICACIONES
Route::get('ubicaciones', function(){
    return Ubicacione::all();
});
//UBICACIÓN POR ID
Route::get('ubicacion/{id}', function($id){
    return Ubicacione::find($id);
});

//TODAS LOS VIAJES
Route::get('viajes', function(){
    return Viaje::all();
});
//VIAJE POR ID
Route::get('viaje/{id}', function($id){
    return Viaje::find($id);
});


//SAVE VIAJE
Route::get('viaje/save/{miviaje}', function($miviaje){
    $miviaje2=json_decode($miviaje);
    $viaje= Viaje::create([
        'cliente_id'=>$miviaje2->cliente_id,
        'chofer_id'=> null,
        'origen_location'=> $miviaje2->origen_location,
        'destino_location'=> $miviaje2->destino_location,
        'categoria_id'=> $miviaje2->categoria_id,
        'precio_inicial'=> $miviaje2->precio_inicial,
        'precio_final'=> null,
        'cantidad_viajeros'=> null,
        'cantidad_objetos'=> null,
        'tipo_objeto_id'=> null,
        'detalles'=> null,
        'status_id'=> 2,
        'puntuacion'=> null,
        'tiempo'=>$miviaje2->tiempo,
        'distancia'=>$miviaje2->distancia,
        'pago_id'=> null,
        'ciudad_id' => $miviaje2->ciudad_id

    ]);
    $newviaje = Viaje::where('id', $viaje->id)->with('cliente', 'estado', 'ciudad')->first();
    return $newviaje;
});

//SAVE UBICACION
Route::get('location/save/{midata}', function($midata){
    $midata2=json_decode($midata);
    $ubicacion= Ubicacione::create([
        'latitud'=>$midata2->latitud,
        'longitud'=>$midata2->longitud,
        'descripcion'=>$midata2->detalle
    ]);
    return $ubicacion;
});


//notificaiones
Route::get('notificaciones', function () {
    $result = Notificacione::all();
    return $result;
});
Route::get('notificacione/save/{message}', function ($message) {
    // $midata2 = json_decode($message);
    $minoti = Notificacione::create([
        'message' => $message
    ]);
    return $minoti;
});

//PIN CLIENTE
Route::get('pin/save/{cliente_id}/{pin}', function ($cliente_id, $pin) {
    $cliente = Cliente::find($cliente_id);
    $cliente->pin = $pin;
    $cliente->save();
    return $cliente;
});
Route::get('pin/get/{telefono}/{pin}', function ($telefono, $pin) {
    $cliente = Cliente::where('telefono', $telefono)->where('pin', $pin)->with('ciudad')->first();
    $cliente->verificado = true;
    $cliente->save();
    return $cliente;
});
Route::get('pin/update/{id}', function ($id) {
    $cliente = Cliente::find($id);
    $cliente->verificado = true;
    $cliente->save();
    return $cliente;
});

//PIN CHOFER
Route::get('chofer/pin/save/{chofer_id}/{pin}', function ($chofer_id, $pin) {
    $chofer = Chofere::find($chofer_id);
    $chofer->pin = $pin;
    $chofer->save();
    return $chofer;
});
Route::get('chofer/pin/get/{telefono}/{pin}', function ($telefono, $pin) {
    $chofer = Chofere::where('telefono', $telefono)->where('pin', $pin)->with('ciudad')->first();
    return $chofer;
});

// monitor solicitudes
Route::get('chofer/verificado', function ($id) {
    $chofer = Chofer::where('estado_verificacion', true)->first();
    return $chofer;
});
