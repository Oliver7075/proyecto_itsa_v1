<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        // Lógica para mostrar el formulario de creación de usuario
    }

    public function store(Request $request)
    {
        // Lógica para almacenar un nuevo usuario en la base de datos
    }

    public function edit($id)
    {
        // Lógica para mostrar el formulario de edición de un usuario específico
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar un usuario específico en la base de datos
    }

    public function destroy($id)
    {
        // Lógica para eliminar un usuario específico de la base de datos
    }
}
