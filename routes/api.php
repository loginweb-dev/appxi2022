<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Categoria;
use App\Chofere;
use App\Ciudade;
use App\Cliente;
use App\Estado;
use App\Negociacione;
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


//CLIENTE
Route::get('cliente/by/{telefono}', function ($telefono) {
    return Cliente::where('telefono', $telefono)->with('ciudad')->first();
});
Route::get('cliente/viajes/{id}', function ($id) {
    return Viaje::where('cliente_id', $id)->with('cliente', 'estado')->orderBy('created_at', 'desc')->get();
});
Route::get('cliente/viaje/negociaciones/{id}', function ($id) {
    //add chofer libre
    // $nego = Negociacione::where('viaje_id', $id)->with('chofer')->get();
    // $chofer = Chofer::where('chofer_id', $nego->chofer_id)->first();
    // if ($chofer->estado) {
    //     # code...
    // } else {
    //     # code...
    // }

    return Negociacione::where('viaje_id', $id)->with('chofer')->get();
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
Route::get('chofer/id/{id}', function($id){
    return Chofere::find($id);
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

//TODAS LOS VIAJES----------------------
Route::get('viajes', function(){
    return Viaje::all();
});

Route::get('viaje/aprobado/{midata}', function($midata){
    $midata2=json_decode($midata);

    $viaje = Viaje::find($midata2->viaje_id);
    $viaje->status_id = 6;
    $viaje->chofer_id = $midata2->chofer_id;
    $viaje->precio_final = $midata2->precio_final;
    $viaje->save();

    $nego = Negociacione::find($midata2->nego_id);
    $nego->status = true;
    $nego->save();

    $chofer = Chofere::find($midata2->chofer_id);
    $chofer->estado = false;
    $chofer->save();

    $newviaje = Viaje::find($midata2->viaje_id);
    return $newviaje;
});

//VIAJE POR ID
Route::get('viaje/{id}', function($id){
    return Viaje::find($id);
});
//Viajes para chofer disponibles
Route::get('viajes_chofer/{ciudad_id}', function($ciudad_id){
    return Viaje::where('ciudad_id',$ciudad_id)->where('status_id',2)->with('cliente')->get();
});
//Viajes hechos por chofer
Route::get('viajes_chofer_concluidos/{id}', function($id){
    return Viaje::where('chofer_id',$id)->where('status_id',4)->with('cliente')->get();
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
        'precio_inicial'=> $miviaje2->precio_ofertado,
        'precio_final'=> null,
        'cantidad_viajeros'=> $miviaje2->cantidad_viajeros,
        'cantidad_objetos'=> $miviaje2->cantidad_objetos,
        'tipo_objeto_id'=> $miviaje2->tipo_objeto_id,
        'detalles'=> null,
        'status_id'=> 2,
        'puntuacion'=> null,
        'tiempo'=>$miviaje2->tiempo,
        'distancia'=>$miviaje2->distancia,
        'pago_id'=> $miviaje2->pago_id,
        'ciudad_id' => $miviaje2->ciudad_id,
        'dt' =>$miviaje2->dt,
        'tt' =>$miviaje2->tt,
        'origen_g' =>$miviaje2->origen_g,
        'destino_g' =>$miviaje2->destino_g,
        'estado' => true
    ]);
    $newviaje = Viaje::where('id', $viaje->id)->with('cliente', 'estado', 'ciudad', 'categoria')->first();
    return $newviaje;
});

//SAVE UBICACION---------------
Route::get('location/save/{midata}', function($midata){
    $midata2=json_decode($midata);
    $ubicacion= Ubicacione::create([
        'latitud'=>$midata2->latitud,
        'longitud'=>$midata2->longitud,
        'descripcion'=>$midata2->detalle
    ]);
    return $ubicacion;
});


//notificaciones
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
    $newcliente = Cliente::where('telefono', $cliente->telefono)->where('pin', $cliente->pin)->with('ciudad')->first();
    return $newcliente;
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

Route::get('chofer/pin/update/{id}', function ($id) {
    $chofer = Chofere::find($id);
    $chofer->verificado = true;
    $chofer->save();
    $newchofer = Chofere::where('telefono', $chofer->telefono)->where('pin', $chofer->pin)->with('ciudad')->first();
    return $newchofer;
});

// monitor solicitudes
Route::get('chofer/verificado', function ($id) {
    $chofer = Chofer::where('estado_verificacion', true)->first();
    return $chofer;
});


//SAVE NECOCIACION
Route::get('save_negociaciones/{midata}',function($midata){
    $midata2= json_decode($midata);

    $negociacion= Negociacione::create([
        'cliente_id'=>$midata2->cliente_id,
        'chofer_id'=>$midata2->chofer_id,
        'viaje_id'=>$midata2->viaje_id,
        'precio_contraofertado'=>$midata2->precio_contraofertado,
        'status'=>$midata2->status
    ]);

    return $negociacion;
});


//Update Estado Chofer
Route::get('update_estado/chofer/{id}/{estado}',function($id,$estado){
    $chofer=Chofere::find($id);
    $chofer->estado=$estado;
    $chofer->save();
});


//Consultar Chofer Ocupado con Viaje(Recogiendo)
Route::get('chofer_viaje_consulta/{id}', function($id){
    $viajes= Viaje::where('chofer_id',$id)->where('status_id',6)->first();
    return $viajes;
});

//Consultar Chofer Ocupado con Viaje(Llevando a su destino)
Route::get('viaje_chofer_encurso/{id}', function($id){
    $viajes= Viaje::where('chofer_id',$id)->where('status_id',3)->first();
    return $viajes;
});


//Concluir Viaje
Route::get('concluir_viaje/{id}',function($id){
    $viaje=Viaje::find($id);
    $viaje->status_id=4;
    $viaje->save();

    return true;
});


//Cancelar Viaje
Route::get('cancelar_viaje/{id}/{detalle}',function($id,$detalle){
    $viaje=Viaje::find($id);
    $viaje->status_id=5;
    $viaje->detalles=$detalle;
    $viaje->save();

    return true;
});

//Pasajero Recogido
Route::get('cliente_recogido/{id}',function($id){
    $viaje=Viaje::find($id);
    $viaje->status_id=3;
    $viaje->save();

    return true;
});

//////////////FILTROS///////////////

//Filtro Numero de Viaje Chofer

// Route::get('viaje_chofer_num/{id}/{num}', function($id,$num){
//     $viajes= Viaje::where('chofer_id',$id)->where('status_id',4)->get();

//     foreach($viajes as $item){

//     }
//     return $viajes;
// });


