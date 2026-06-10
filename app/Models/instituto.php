<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instituto extends Model
{
    protected $table = 'instituto';
    protected $fillable = [
        'nombre_regulador', 'ubicacion', 'caracter', 'nombre_impuestos', 'nit',
        'actividad_economica', 'precio_credito', 'resolucion_ministerial',
        'abreviatura', 'token', 'rector', 'director_academico', 'logo','nombre_instituto','telefono','id_directoracademico','id_rector'
    ];
}
