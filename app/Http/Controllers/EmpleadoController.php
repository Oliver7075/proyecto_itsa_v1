<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\User;
use App\Models\Cuenta;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('persona')->get();
        return view('admin.empleados.index', compact('empleados'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('admin.empleados.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $resultado = DB::transaction(function () use ($request, $validated) {
            $personaData = collect($validated)->only([
                'nombre', 'primerapellido', 'segundoapellido', 'dni', 'fechanacimiento',
                'lugarnacimiento', 'nacionalidad', 'sexo', 'lugarexpedicion', 'direccion',
                'telefono', 'celular', 'email',
            ])->all();
            $personaData['tipo'] = 'empleado';
            if ($request->hasFile('foto')) {
                $personaData['foto'] = $request->file('foto')->store('personas', 'public');
            }

            $persona = Persona::create($personaData);
            Empleado::create([
                'id_persona' => $persona->id_persona,
                'abreviaturaprofesion' => $validated['abreviaturaprofesion'] ?? null,
                'codigo' => $validated['codigo'] ?? null,
            ]);

            $anio = date('Y');
            $ultimoUsuario = User::where('usuario', 'LIKE', $anio . '%')
                ->orderByDesc('usuario')
                ->first();

            $contador = $ultimoUsuario ? ((int) substr($ultimoUsuario->usuario, 4)) + 1 : 1;
            $usuarioGenerado = $anio . str_pad($contador, 4, '0', STR_PAD_LEFT);

            $caracteres = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
            $passwordGenerada = substr(str_shuffle($caracteres), 0, 10);

            $usuario = User::create([
                'id_persona' => $persona->id_persona,
                'usuario' => $usuarioGenerado,
                'password' => Hash::make($passwordGenerada),
            ]);

            $rol = Rol::findOrFail($validated['id_rol']);

            Cuenta::create([
                'id_persona' => $persona->id_persona,
                'id_rol' => $validated['id_rol'],
                'usuario' => $usuarioGenerado,
                'password' => Hash::make($passwordGenerada),
            ]);

            return compact('persona', 'usuario', 'rol', 'passwordGenerada');
        });

        $persona = $resultado['persona'];
        $usuario = $resultado['usuario'];
        $rol = $resultado['rol'];
        $passwordGenerada = $resultado['passwordGenerada'];

        $datosPdf = [
            'titulo'        => 'COMPROBANTE DE CREDENCIALES DE ACCESO',
            'user'          => (object) [
                'name'     => trim($persona->nombre . ' ' . $persona->primerapellido . ' ' . ($persona->segundoapellido ?? '')),
                'ci'       => $persona->dni,
                'role'     => $rol->nombre,
                'carrera'  => '-',
                'email'    => $persona->email,
                'username' => $usuario->usuario,
            ],
            'plainPassword' => $passwordGenerada,
            'fecha'         => now()->format('d/m/Y H:i'),
        ];

        $pdf = Pdf::loadView('pdf.credenciales', $datosPdf);

        return $pdf->stream('credenciales_' . $persona->dni . '.pdf');
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        $roles    = Rol::all();
        $usuario  = User::where('id_persona', $empleado->id_persona)->first();
        
        return view('admin.empleados.edit', compact('empleado', 'roles', 'usuario'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);
        $persona  = $empleado->persona;
        $usuario  = User::where('id_persona', $empleado->id_persona)->first();

        $validated = $request->validate($this->rules($persona->id_persona, $usuario?->id_persona));

        // Actualizar persona
        $persona->update(collect($validated)->only([
            'nombre', 'primerapellido', 'segundoapellido', 'dni', 
            'fechanacimiento', 'lugarnacimiento', 'nacionalidad', 
            'sexo', 'lugarexpedicion', 'direccion', 'telefono', 
            'celular', 'email'
        ])->all());
        if ($request->hasFile('foto')) {
            $persona->update(['foto' => $request->file('foto')->store('personas', 'public')]);
        }

        // Actualizar empleado
        $empleado->update(collect($validated)->only(['abreviaturaprofesion', 'codigo'])->all());

        // Actualizar usuario
        if ($usuario) {
            $usuario->update(['usuario' => $validated['usuario']]);
            $cuenta = $usuario->cuenta;
            $cuentaData = ['id_rol' => $validated['id_rol'], 'usuario' => $validated['usuario']];
            if ($request->filled('password')) {
                $password = Hash::make($validated['password']);
                $usuario->update(['password' => $password]);
                $cuentaData['password'] = $password;
            } elseif ($cuenta) {
                $cuentaData['password'] = $cuenta->password;
            } else {
                $cuentaData['password'] = $usuario->password;
            }
            Cuenta::updateOrCreate(['id_persona' => $usuario->id_persona], $cuentaData);
        }

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->persona->delete(); // Elimina en cascada empleado y usuario

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }

    private function rules(?int $personaId = null, ?int $usuarioId = null): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'primerapellido' => ['required', 'string', 'max:255'],
            'segundoapellido' => ['nullable', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:50', Rule::unique('personas', 'dni')->ignore($personaId, 'id_persona')],
            'fechanacimiento' => ['nullable', 'date', 'before:today'],
            'lugarnacimiento' => ['nullable', 'string', 'max:255'],
            'nacionalidad' => ['nullable', 'string', 'max:100'],
            'sexo' => ['nullable', 'in:MASCULINO,FEMENINO'],
            'lugarexpedicion' => ['nullable', 'string', 'max:255'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'digits_between:7,15'],
            'celular' => ['nullable', 'digits_between:7,15'],
            'email' => ['nullable', 'email', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'abreviaturaprofesion' => ['nullable', 'string', 'max:100'],
            'codigo' => ['nullable', 'string', 'max:255'],
            'id_rol' => ['required', 'exists:rol,id_rol'],
            'usuario' => [Rule::requiredIf($personaId !== null), 'nullable', 'string', 'max:255', Rule::unique('users', 'usuario')->ignore($usuarioId, 'id_persona')],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}