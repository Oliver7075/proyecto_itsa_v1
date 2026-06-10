<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instituto;

class InstitutoController extends Controller
{
    public function index() {
        $instituto = Instituto::first(); // Asumiendo que solo hay un registro de instituto
        return view('admin.instituto.index', compact('instituto'));
    }

    public function update(Request $request) {
        //$request->validate([...]); // Agrega tus reglas de validación aquí

        $instituto = Instituto::firstOrNew(['id' => 1]);
        $instituto->fill($request->all());
        $instituto->save();

        return back()->with('success', 'Configuración actualizada correctamente');
    }
}
