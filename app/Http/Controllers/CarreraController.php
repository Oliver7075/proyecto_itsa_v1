<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Empleado;
use App\Models\Instituto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::all();
        return view('planes.carreras.index', compact('carreras'));
    }

    public function create()
    {
        return view('planes.carreras.create', $this->formData());
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        Carrera::create($validated);

        return redirect()->route('planes.carreras.index')->with('success', 'Carrera creada correctamente.');
    }

    public function edit($id)
    {
        $carrera = Carrera::findOrFail($id);

        return view('planes.carreras.edit', array_merge(['carrera' => $carrera], $this->formData()));
    }

    public function update(Request $request, $id)
    {
        $carrera = Carrera::findOrFail($id);
        $validated = $request->validate($this->rules($carrera->id_carrera));
        $carrera->update($validated);

        return redirect()->route('planes.carreras.index')->with('success', 'Carrera actualizada correctamente.');
    }

    public function destroy($id)
    {
        Carrera::findOrFail($id)->delete();

        return redirect()->route('planes.carreras.index')->with('success', 'Carrera eliminada correctamente.');
    }

    private function formData(): array
    {
        return [
            'institutos' => Instituto::orderBy('nombreinstituto')->get(),
            'jefesCarrera' => Empleado::with('persona')->get(),
        ];
    }

    private function rules(?int $id = null): array
    {
        return [
            'codigo' => ['required', 'string', 'max:255', Rule::unique('carreras', 'codigo')->ignore($id, 'id_carrera')],
            'nombre' => ['required', 'string', 'max:255'],
            'creditajeadmision' => ['nullable', 'integer', 'min:0'],
            'creditajematricula' => ['nullable', 'integer', 'min:0'],
            'nivelacademico' => ['nullable', 'integer', 'min:0'],
            'regimen' => ['nullable', 'integer', 'min:0'],
            'resolucionministerial1' => ['nullable', 'string', 'max:255'],
            'resolucionministerial2' => ['nullable', 'string', 'max:255'],
            'resolucionministerial3' => ['nullable', 'string', 'max:255'],
            'version' => ['nullable', 'integer', 'min:0'],
            'id_instituto' => ['required', 'exists:instituto,id_instituto'],
            'id_jefecarrera' => ['nullable', 'exists:empleados,id_persona'],
        ];
    }
}
