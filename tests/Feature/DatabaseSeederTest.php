<?php

namespace Tests\Feature;

use App\Models\Actividad;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Persona;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_consistent_demo_data_and_can_be_run_repeatedly(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('personas', 2);
        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('rol', 2);
        $this->assertDatabaseCount('instituto', 1);
        $this->assertDatabaseCount('carreras', 1);
        $this->assertDatabaseCount('gestionacademica', 1);
        $this->assertDatabaseCount('materia', 2);
        $this->assertDatabaseCount('grupo', 1);
        $this->assertDatabaseCount('actividad', 3);

        $this->assertDatabaseHas('carreras', [
            'codigo' => 'DEMO-SIS',
            'id_jefecarrera' => Persona::where('dni', '87654321')->value('id_persona'),
        ]);
        $this->assertDatabaseHas('prerequisito', [
            'id_materia' => Materia::where('codigo', 'DEMO-SIS-201')->value('id_materia'),
            'id_prerequisito' => Materia::where('codigo', 'DEMO-SIS-101')->value('id_materia'),
        ]);
        $this->assertDatabaseHas('actividad_carrera', [
            'id_actividad' => Actividad::where('nombre', 'Actividad de prueba por carrera')->value('id_actividad'),
            'id_carrera' => Carrera::where('codigo', 'DEMO-SIS')->value('id_carrera'),
        ]);
        $this->assertDatabaseHas('actividad_usuario', [
            'id_actividad' => Actividad::where('nombre', 'Actividad de prueba por usuario')->value('id_actividad'),
            'id_persona' => User::where('usuario', '20260001')->value('id_persona'),
        ]);

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('personas', 2);
        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('rol', 2);
        $this->assertDatabaseCount('instituto', 1);
        $this->assertDatabaseCount('carreras', 1);
        $this->assertDatabaseCount('gestionacademica', 1);
        $this->assertDatabaseCount('materia', 2);
        $this->assertDatabaseCount('grupo', 1);
        $this->assertDatabaseCount('actividad', 3);
    }
}
