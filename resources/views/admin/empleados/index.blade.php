@extends('adminlte::page')
@section('content')
<div class="card mt-3">
    <div class="card-header">
        <a href="{{ route('admin.empleados.create') }}" class="btn btn-default"><i class="fa fa-plus"></i> Nuevo</a>
        <a href="{{ route('admin.empleados.index') }}" class="btn btn-default"><i class="fa fa-sync"></i> Actualizar</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.empleados.index') }}" method="GET" class="mb-3">
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
                    <th>Primer Apellido</th><th>Segundo Apellido</th><th>Nombre</th><th>DNI</th><th>Dirección</th>
                    <th>Teléfono</th><th>Celular</th><th>Email</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $emp)
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