<?php

namespace Database\Seeders;

use App\Models\Cuenta;
use App\Models\Persona;
use App\Models\Recurso;
use App\Models\Rol;
use App\Models\User;
use App\Support\MenuResourceSync;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        MenuResourceSync::sync();

        $rolAdmin = Rol::firstOrCreate(['nombre' => 'Administrador']);
        $recursos = Recurso::all();
        $rolAdmin->recursos()->sync($recursos->pluck('id_recurso')->all());

        Persona::firstOrCreate(
            ['id_persona' => 1],
            [
                'tipo' => 'admin',
                'celular' => '123456789',
                'direccion' => 'Calle Falsa 123',
                'dni' => '12345678',
                'email' => 'admin@example.com',
                'fechanacimiento' => '1990-01-01',
                'foto' => null,
                'lugarexpedicion' => 'Ciudad',
                'lugarnacimiento' => 'Ciudad',
                'nacionalidad' => 'País',
                'nombre' => 'Admin',
                'primerapellido' => 'Root',
                'segundoapellido' => 'Admin',
                'sexo' => 'M',
                'telefono' => '123456789',
            ]
        );

        $usuario = User::firstOrCreate(
            ['id_persona' => 1],
            [
                'usuario' => '20260001',
                'password' => Hash::make('adminroot'),
            ]
        );

        Cuenta::updateOrCreate(
            ['id_persona' => 1, 'id_rol' => $rolAdmin->id_rol],
            [
                'usuario' => $usuario->usuario,
                'password' => Hash::make('adminroot'),
            ]
        );
    }
}
