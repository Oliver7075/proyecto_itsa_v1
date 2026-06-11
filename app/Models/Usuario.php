<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_persona';
    public $incrementing = false; // Para indicar que la clave primaria no es auto-incremental
    protected $fillable = ['id_persona', 'contrasena', 'usuario'];

    // Relación con Persona (uno a uno)
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona'); // Relación con Persona usando id_persona como clave foránea
    }
}
