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
        $request->validate([
            'nombre'          => 'required|string',
            'primerapellido'  => 'required|string',
            'segundoapellido' => 'nullable|string',
            'dni'             => 'required|string|unique:personas,dni',
            'id_rol'          => 'required|exists:rol,id_rol',
            'email'           => 'nullable|email',
        ]);

        $persona = Persona::create([
            'nombre'          => $request->nombre,
            'primerapellido'  => $request->primerapellido,
            'segundoapellido' => $request->segundoapellido,
            'dni'             => $request->dni,
            'fechanacimiento' => $request->fechanacimiento,
            'lugarnacimiento' => $request->lugarnacimiento,
            'nacionalidad'    => $request->nacionalidad,
            'sexo'            => $request->sexo,
            'lugarexpedicion' => $request->lugarexpedicion,
            'direccion'       => $request->direccion,
            'telefono'        => $request->telefono,
            'celular'         => $request->celular,
            'email'           => $request->email,
            'foto'            => $request->foto,
            'tipo'            => 'empleado',
        ]);

        Empleado::create([
            'id_persona'           => $persona->id_persona,
            'abreviaturaprofesion' => $request->abreviaturaprofesion,
            'codigo'               => $request->codigo,
        ]);

        $anio = date('Y');
        $ultimoUsuario = User::where('usuario', 'LIKE', $anio . '%')
            ->orderByRaw('CAST(SUBSTRING(usuario, 5) AS UNSIGNED) DESC')
            ->first();

        $contador = $ultimoUsuario ? ((int) substr($ultimoUsuario->usuario, 4)) + 1 : 1;
        $usuarioGenerado = $anio . str_pad($contador, 4, '0', STR_PAD_LEFT);

        $caracteres = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
        $passwordGenerada = substr(str_shuffle($caracteres), 0, 10);

        $usuario = User::create([
            'id_persona' => $persona->id_persona,
            'usuario'    => $usuarioGenerado,
            'password'   => Hash::make($passwordGenerada),
        ]);

        $rol = Rol::findOrFail($request->id_rol);

        Cuenta::create([
            'id_persona' => $persona->id_persona,
            'id_rol'     => $request->id_rol,
            'usuario'    => $usuarioGenerado,
            'password'   => Hash::make($passwordGenerada),
        ]);

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

        $request->validate([
            'nombre'          => 'required',
            'primerapellido'  => 'required',
            'segundoapellido' => 'required',
            'dni'             => 'required|unique:personas,dni,' . $persona->id_persona . ',id_persona',
            'id_rol'          => 'required|exists:rol,id_rol',
            'usuario'         => 'required|unique:users,usuario,' . ($usuario ? $usuario->id_persona : 'NULL') . ',id_persona',
        ]);

        // Actualizar persona
        $persona->update($request->only([
            'nombre', 'primerapellido', 'segundoapellido', 'dni', 
            'fechanacimiento', 'lugarnacimiento', 'nacionalidad', 
            'sexo', 'lugarexpedicion', 'direccion', 'telefono', 
            'celular', 'email', 'foto'
        ]));

        // Actualizar empleado
        $empleado->update($request->only(['abreviaturaprofesion', 'codigo']));

        // Actualizar usuario
        if ($usuario) {
            $datosUsuario = [
                'id_rol'  => $request->id_rol,
                'usuario' => $request->usuario,
            ];
            if ($request->filled('password')) {
                $datosUsuario['password'] = Hash::make($request->password);
            }
            $usuario->update($datosUsuario);
        }

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->persona->delete(); // Elimina en cascada empleado y usuario

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}