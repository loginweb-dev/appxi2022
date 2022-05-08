<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Chofere extends Model
{
    use SoftDeletes;
	protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'ciudad_id',
        'email',
        'perfil',
        'vehiculo',
        'carnet',
        'breve',
        'estado',
        'categoria_id',
        'estado_verificacion',
        'creditos',
        'pin'

    ];

    public function ciudad()
    {
        return $this->belongsTo(Ciudade::class, 'ciudad_id');
    }
}
