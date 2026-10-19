<?php

namespace Tests\Feature;

use App\Models\Instituto;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Support\EnablesFunctionality;
use Tests\TestCase;

class CarreraInstituteTest extends TestCase
{
    use RefreshDatabase;
    use EnablesFunctionality;

    public function test_career_uses_configured_institute_when_created_and_updated(): void
    {
        $persona = Persona::create([
            'nombre' => 'Admin',
            'primerapellido' => 'Sistema',
            'dni' => '11111111',
            'tipo' => 'admin',
        ]);
        $user = User::create([
            'id_persona' => $persona->id_persona,
            'usuario' => 'admin_test',
            'password' => Hash::make('password123'),
        ]);

        $institutoConfigurado = Instituto::create(['nombreinstituto' => 'Instituto Configurado']);
        $otroInstituto = Instituto::create(['nombreinstituto' => 'Otro Instituto']);
        $this->enableFunctionality('planes/carreras');

        $this->actingAs($user)
            ->get(route('planes.carreras.create'))
            ->assertOk()
            ->assertSee('Instituto Configurado');

        $datosCarrera = [
            'codigo' => 'INF-001',
            'nombre' => 'Informática',
            'id_instituto' => $otroInstituto->id_instituto,
            'creditajeadmision' => 10,
            'creditajematricula' => 20,
            'nivelacademico' => 1,
            'regimen' => 1,
            'version' => 1,
        ];

        $this->post(route('planes.carreras.store'), $datosCarrera)
            ->assertRedirect(route('planes.carreras.index'));

        $this->assertDatabaseHas('carreras', [
            'codigo' => 'INF-001',
            'id_instituto' => $institutoConfigurado->id_instituto,
        ]);

        $carrera = \App\Models\Carrera::where('codigo', 'INF-001')->firstOrFail();
        $this->put(route('planes.carreras.update', $carrera->id_carrera), [
            ...$datosCarrera,
            'codigo' => 'INF-001',
            'id_instituto' => $otroInstituto->id_instituto,
            'resolucionministerial1' => 'RM-123',
        ])->assertRedirect(route('planes.carreras.index'));

        $this->assertDatabaseHas('carreras', [
            'id_carrera' => $carrera->id_carrera,
            'id_instituto' => $institutoConfigurado->id_instituto,
            'resolucionministerial1' => 'RM-123',
        ]);

        $this->get(route('planes.carreras.index'))
            ->assertOk()
            ->assertSee('10')
            ->assertSee('20')
            ->assertSee('RM-123');
    }
}
