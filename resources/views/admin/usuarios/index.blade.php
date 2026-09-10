@extends('adminlte::page')
@section('title', 'Usuarios')

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <form action="{{ route('admin.usuarios.index') }}" method="GET" class="mb-0">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $index => $usuario)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $usuario->persona->primerapellido }}</td>
                    <td>{{ $usuario->persona->segundoapellido }}</td>
                    <td>{{ $usuario->persona->nombre }}</td>
                    <td>{{ $usuario->persona->email }}</td>
                    <td>{{ $usuario->usuario }}</td>
                    <td>
                        @if($usuario->cuenta && $usuario->cuenta->rol)
                            <span class="badge badge-primary">{{ $usuario->cuenta->rol->nombre }}</span>
                        @else
                            <span class="badge badge-secondary">Sin rol</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.usuarios.edit', $usuario->id_persona) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                        <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-key"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No hay usuarios registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop