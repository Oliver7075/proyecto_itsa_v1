<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    protected $fillable = ['nombre', 'primerapellido', 'segundoapellido', 'dni', 'lugarexpedicion', 'fechanacimiento', 'lugarnacimiento', 'nacionalidad', 'sexo', 
    'direccion','telefono','celular','email','tipo','foto'];
}
