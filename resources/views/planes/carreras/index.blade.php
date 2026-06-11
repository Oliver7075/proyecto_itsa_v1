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
                    <th>Codigo</th>Nombre<th></th><th>Regimen</th><th>Nivel Academico</th><th>Version</th>
                    <th>Resolucion ministerial 1</th><th>Resolucion ministerial 2</th><th>Resolucion ministerial 3</th><th>Mencion</th><th>Creditaje matricula</th><th>Jefe de Carrera</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carreras as $emp)
                <tr>
                    <td>{{ $emp->persona->primerapellido }}</td>
                    <td>{{ $emp->persona->segundoapellido }}</td>
                    <td>{{ $emp->persona->nombre }}</td>
                    <td>{{ $emp->persona->dni }}</td>
                    <td>{{ $emp->persona->direccion }}</td>
                    <td>{{ $emp->persona->telefono }}</td>
                    <td>{{ $emp->persona->celular }}</td>
                    <td>{{ $emp->persona->email }}</td>
                    <td>
                        <a href="{{ route('admin.empleados.edit', $emp->id_persona) }}" class="btn btn-sm btn-default"><i class="fa fa-edit"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop