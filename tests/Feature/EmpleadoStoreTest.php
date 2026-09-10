<?php

namespace Tests\Feature;

use App\Models\Persona;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EmpleadoStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_can_be_created_and_user_record_generated_with_pdf_response(): void
    {
        $adminPersona = Persona::create([
            'nombre' => 'Admin',
            'primerapellido' => 'Sistema',
            'segundoapellido' => 'Test',
            'dni' => '11111111',
            'tipo' => 'admin',
        ]);

        $adminUser = User::create([
            'id_persona' => $adminPersona->id_persona,
            'usuario' => 'admin_test',
            'password' => Hash::make('password123'),
        ]);

        $rol = Rol::create(['nombre' => 'Administrador']);

        $response = $this->actingAs($adminUser)->post(route('admin.empleados.store'), [
            'nombre' => 'Juan',
            'primerapellido' => 'Pérez',
            'segundoapellido' => 'Gómez',
            'dni' => '98765432',
            'fechanacimiento' => '1990-05-10',
            'lugarnacimiento' => 'La Paz',
            'nacionalidad' => 'Boliviana',
            'sexo' => 'MASCULINO',
            'lugarexpedicion' => 'Santa Cruz',
            'direccion' => 'Av. Principal 123',
            'telefono' => '3456789',
            'celular' => '71234567',
            'email' => 'juan@example.com',
            'foto' => '',
            'abreviaturaprofesion' => 'Ing.',
            'codigo' => 'EMP-001',
            'id_rol' => $rol->id_rol,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('personas', ['dni' => '98765432']);
        $this->assertDatabaseHas('empleados', ['codigo' => 'EMP-001']);
        $this->assertDatabaseCount('users', 2);

        $empleadoUser = User::where('id_persona', Persona::where('dni', '98765432')->value('id_persona'))->first();
        $this->assertNotNull($empleadoUser);
        $this->assertMatchesRegularExpression('/^' . date('Y') . '\d{4}$/', $empleadoUser->usuario);

        $pdfContent = $response->getContent();
        $this->assertNotEmpty($pdfContent);
        $this->assertMatchesRegularExpression('/[A-Za-z0-9]{10}/', $pdfContent);

        $this->assertDatabaseHas('cuenta', ['id_persona' => $empleadoUser->id_persona, 'id_rol' => $rol->id_rol]);
    }
}
