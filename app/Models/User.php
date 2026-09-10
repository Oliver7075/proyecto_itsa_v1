<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_persona';
    public $incrementing = false; // Indica que no es autoincremental
    protected $keyType = 'unsignedBigInteger'; // O el tipo de dato de id_persona (int/string)

    protected $fillable = [
        'id_persona',
        'usuario',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mapea la columna de contraseña real para Laravel Auth.
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getNameAttribute()
    {
        if ($this->relationLoaded('persona') && $this->persona) {
            return trim(($this->persona->nombre ?? '') . ' ' . ($this->persona->primerapellido ?? ''));
        }

        $persona = $this->persona()->first();

        if ($persona) {
            return trim(($persona->nombre ?? '') . ' ' . ($persona->primerapellido ?? ''));
        }

        return $this->usuario ?? 'Usuario';
    }

    /**
     * Relación uno a uno / pertenece a Persona.
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    /**
     * Relación uno a muchos con Cuenta.
     */
    public function cuenta()
    {
        return $this->hasOne(Cuenta::class, 'id_persona', 'id_persona');
    }

    public function tieneAccesoA($url)
    {
        $urlNormalizada = trim((string) $url, '/');

        if ($urlNormalizada === '') {
            return true;
        }

        if ((int) $this->id_persona === 1 || $this->usuario === '20260001') {
            return true;
        }

        $rol = $this->cuenta?->rol;

        if (!$rol) {
            return true;
        }

        return $rol->recursos()->where('urlpattern', $urlNormalizada)->exists();
    }

    public function canAccess($path)
    {
        return $this->tieneAccesoA($path);
    }
}