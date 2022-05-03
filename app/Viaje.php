<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Viaje extends Model
{
	use SoftDeletes;

    protected $fillable = [
    'cliente_id',
    'chofer_id',
    'origen_location',
    'destino_location',
    'categoria_id',
    'precio_inicial',
    'precio_final',
    'cantidad_viajeros',
    'cantidad_objetos',
    'tipo_objeto_id',
    'detalles',
    'status_id',
    'puntuacion',
    'tiempo',
    'distancia',
    'pago_id'
    ];


}
