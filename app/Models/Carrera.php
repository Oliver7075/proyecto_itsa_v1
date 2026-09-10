<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carreras';
    protected $primaryKey = 'id_carrera';
    protected $fillable = [ 'codigo', 'creditajeadmision','creditajematricula', 'nivelacademico', 'nombre', 'regimen', 'resolucionministerial1', 'resolucionministerial2',
            'resolucionministerial3', 'version', 'id_instituto', 'id_jefecarrera'
    ];
}
