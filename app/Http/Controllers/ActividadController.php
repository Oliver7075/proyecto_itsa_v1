<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\GestionAcademica;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    public function index(Request $request)
    {
        $gestiones = GestionAcademica::orderByDesc('gestion')->orderBy('periodo')->get();
        $actividades = Actividad::with('gestionAcademica')
            ->when($request->filled('id_gestionacademica'), fn ($query) =>
                $query->where('id_gestionacademica', $request->id_gestionacademica))
            ->when($request->filled('buscar'), fn ($query) =>
                $query->where('nombre', 'like', '%' . $request->buscar . '%'))
            ->orderBy('inicio')
            ->get();

        return view('gestiones.calendario.index', compact('gestiones', 'actividades'));
    }

    public function create(Request $request)
    {
        $gestiones = GestionAcademica::orderByDesc('gestion')->orderBy('periodo')->get();
        $gestionSeleccionada = $request->input('id_gestionacademica');

        return view('gestiones.calendario.create', compact('gestiones', 'gestionSeleccionada'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        Actividad::create($validated);

        return redirect()->route('admin.actividad.index', [
            'id_gestionacademica' => $validated['id_gestionacademica'],
        ])->with('success', 'Actividad creada correctamente.');
    }

    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id);
        $gestiones = GestionAcademica::orderByDesc('gestion')->orderBy('periodo')->get();

        return view('gestiones.calendario.edit', compact('actividad', 'gestiones'));
    }

    public function update(Request $request, $id)
    {
        $actividad = Actividad::findOrFail($id);
        $validated = $request->validate($this->rules());
        $actividad->update($validated);

        return redirect()->route('admin.actividad.index', [
            'id_gestionacademica' => $validated['id_gestionacademica'],
        ])->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy($id)
    {
        $actividad = Actividad::findOrFail($id);
        $gestion = $actividad->id_gestionacademica;
        $actividad->delete();

        return redirect()->route('admin.actividad.index', [
            'id_gestionacademica' => $gestion,
        ])->with('success', 'Actividad eliminada correctamente.');
    }

    private function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'inicio' => ['nullable', 'date'],
            'fin' => ['nullable', 'date', 'after_or_equal:inicio'],
            'funcionalidad' => ['nullable', 'integer'],
            'id_gestionacademica' => ['required', 'exists:gestionacademica,id_gestionacademica'],
        ];
    }
}
