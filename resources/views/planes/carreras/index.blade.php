@extends('adminlte::page')
@section('content')
<div class="card mt-3">
    <div class="card-header">
        <a href="{{ route('planes.carreras.create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Nuevo</a>
        <a href="{{ route('planes.carreras.index') }}" class="btn btn-default"><i class="fa fa-sync"></i> Actualizar</a>
    </div>
    <div class="card-body">
        <form action="{{ route('planes.carreras.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar...">
                <div class="input-group-append">
                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Nivel académico</th>
                    <th>Versión</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($carreras as $carrera)
                <tr>
                    <td>{{ $carrera->codigo ?? '-' }}</td>
                    <td>{{ $carrera->nombre }}</td>
                    <td>{{ $carrera->nivelacademico ?? '-' }}</td>
                    <td>{{ $carrera->version ?? '-' }}</td>
                    <td>
                        <a href="{{ route('planes.carreras.edit', $carrera->id_carrera) }}" class="btn btn-sm btn-info" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('planes.carreras.materias.import', $carrera->id_carrera) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-file-upload"></i> Cargar materias
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay carreras registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop