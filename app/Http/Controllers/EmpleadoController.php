<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Persona;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('admin.empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('admin.empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'primerapellido' => 'required',
            'segundoapellido' => 'required',
            'dni' => 'required|unique:personas,dni',
            // Agrega validaciones para otros campos según sea necesario
        ]);

        // Crear una nueva persona
        $persona = Persona::create([
            'nombre' => $request->nombre,
            'primerapellido' => $request->primerapellido,
            'segundoapellido' => $request->segundoapellido,
            'dni' => $request->dni,
            'fechanacimiento' => $request->fechanacimiento,
            'lugarnacimiento' => $request->lugarnacimiento,
            'nacionalidad' => $request->nacionalidad,
            'sexo' => $request->sexo,
            'lugarexpedicion' => $request->lugarexpedicion,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'celular' => $request->celular,
            'email' => $request->email,
            'foto' => $request->foto,
            'tipo' => 'empleado',
            // Agrega otros campos según sea necesario
        ]);

        // Crear un nuevo empleado asociado a la persona creada
        Empleado::create([
            'id_persona' => $persona->id_persona,
            'abreviaturaprofesion' => $request->abreviaturaprofesion,
            'codigo' => $request->codigo,
        ]);

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('admin.empleados.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);
        $persona = $empleado->persona;

        $request->validate([
            'nombre' => 'required',
            'primerapellido' => 'required',
            'segundoapellido' => 'required',
            'dni' => 'required|unique:personas,dni,' . $persona->id_persona . ',id_persona',
            // Agrega validaciones para otros campos según sea necesario
        ]);

        // Actualizar la persona asociada al empleado
        $persona->update([
            'nombre' => $request->nombre,
            'primerapellido' => $request->primerapellido,
            'segundoapellido' => $request->segundoapellido,
            'dni' => $request->dni,
            'fechanacimiento' => $request->fechanacimiento,
            'lugarnacimiento' => $request->lugarnacimiento,
            'nacionalidad' => $request->nacionalidad,
            'sexo' => $request->sexo,
            'lugarexpedicion' => $request->lugarexpedicion,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'celular' => $request->celular,
            'email' => $request->email,
            'foto' => $request->foto,
            'tipo' => 'empleado',

            // Agrega otros campos según sea necesario
        ]);

        // Actualizar el empleado
        $empleado->update([
            'abreviaturaprofesion' => $request->abreviaturaprofesion,
            'codigo' => $request->codigo,
        ]);

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $persona = $empleado->persona;

        // Eliminar el empleado
        $empleado->delete();

        // Eliminar la persona asociada al empleado
        $persona->delete();

        return redirect()->route('admin.empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}
