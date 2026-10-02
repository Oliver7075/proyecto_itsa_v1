<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instituto;

class InstitutoController extends Controller
{
    public function index() {
        $instituto = Instituto::first() ?? new Instituto();
        return view('admin.instituto.index', compact('instituto'));
    }

    public function update(Request $request) {
        $validated = $request->validate([
            'nombreinstituto' => ['required', 'string', 'max:255'],
            'nombreregulador' => ['required', 'string', 'max:255'],
            'ubicacion' => ['required', 'string', 'max:255'],
            'caracter' => ['required', 'in:FISCAL,PRIVADO'],
            'nombreimpuestos' => ['nullable', 'string', 'max:255'],
            'nit' => ['nullable', 'string', 'max:255'],
            'actividadeconomica' => ['nullable', 'string', 'max:255'],
            'preciocredito' => ['required', 'integer', 'min:0'],
            'resolucionministerial' => ['required', 'string', 'max:255'],
            'abreviatura' => ['required', 'string', 'max:255'],
            'token' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $instituto = Instituto::firstOrNew(['id_instituto' => 1]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('instituto', 'public');
        }
        $instituto->fill($validated);
        $instituto->save();

        return back()->with('success', 'Configuración actualizada correctamente');
    }
}
