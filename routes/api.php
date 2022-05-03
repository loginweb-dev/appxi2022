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
    $cliente = Cliente::where('telefono', $telefono)->with('ciudad')->first();
    if ($cliente) {
        return $cliente;
    } else {
        $newcliente = App\Cliente::create([
            'telefono' => $telefono,
            'ciudad_id' => 1
        ]);
        return $newcliente;
    }
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
Route::get('saveviaje/{miviaje}', function($miviaje){
    $miviaje2=json_decode($miviaje);

    $viaje= Viaje::create([
        'cliente_id'=>$miviaje2->cliente_id,
        'chofer_id'=>$miviaje2->chofer_id,
        'origen_location'=>$miviaje2->origen_location,
        'destino_location'=>$miviaje2->destino_location,
        'categoria_id'=>$miviaje2->categoria_id,
        'precio_inicial'=>$miviaje2->precio_inicial,
        'precio_final'=>$miviaje2->precio_final,
        'cantidad_viajeros'=>$miviaje2->cantidad_viajeros,
        'cantidad_objetos'=>$miviaje2->cantidad_objetos,
        'tipo_objeto_id'=>$miviaje2->tipo_objeto_id,
        'detalles'=>$miviaje2->detalles,
        'status_id'=>$miviaje2->status_id,
        'puntuacion'=>$miviaje2->puntuacion,
        'tiempo'=>$miviaje2->tiempo,
        'distancia'=>$miviaje2->distancia,
        'pago_id'=>$miviaje2->pago_id

    ]);

    return $viaje;

});

//SAVE UBICACION
Route::get('saveubicacion/{miubicacion}', function($miubicacion){
    $miubicacion2=json_decode($miubicacion);

    $ubicacion= Viaje::create([
        'latitud'=>$miubicacion2->latitud,
        'longitud'=>$miubicacion2->longitud,
        'descripcion'=>$miubicacion2->descripcion

    ]);
    return $ubicacion;
});
