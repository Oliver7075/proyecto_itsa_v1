<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividad';
    protected $primaryKey = 'id_actividad';
    protected $fillable = [
        'nombre',
        'descripcion',
        'inicio',
        'fin',
        'funcionalidad',
        'id_gestionacademica',
    ];

    public function gestionAcademica()
    {
        return $this->belongsTo(GestionAcademica::class, 'id_gestionacademica', 'id_gestionacademica');
    }
}
