@extends('adminlte::page')

@section('title', 'Gestión de Carreras')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Carrera <small class="text-muted">gestión de carreras</small></h1>
        </div>
    </div>
@stop

@section('content')
<div class="card mt-3">
    <!-- Cabecera con Botonera -->
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="btn-toolbar" role="toolbar">
                <a href="{{ route('planes.carreras.create') }}" class="btn btn-default mr-2 mb-2">
                    <i class="fa fa-plus"></i> Nuevo
                </a>
                <a href="{{ route('planes.carreras.index') }}" class="btn btn-default mb-2">
                    <i class="fa fa-sync"></i> Actualizar
                </a>
            </div>
            <div>
                <button type="button" class="btn btn-default mb-2" title="Configuración">
                    <i class="fas fa-cog"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- Formulario de Búsqueda -->
        <form action="{{ route('planes.carreras.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar...">
                <div class="input-group-append">
                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <!-- Contenedor responsive para la tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-sm">
                <thead>
                    <tr class="text-center">
                        <th>Nº</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Créditos admisión</th>
                        <th>Regimen</th>
                        <th>Nivel Académico</th>
                        <th>Versión</th>
                        <th>Resolución ministerial 1</th>
                        <th>Resolución ministerial 2</th>
                        <th>Resolución ministerial 3</th>
                        <th>Creditaje matricula</th>
                        <th>Jefe de Carrera</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($carreras as $carrera)
                    <tr>
                        <td class="text-center font-weight-bold">{{ $loop->iteration }}</td>
                        <td>{{ $carrera->codigo ?? '-' }}</td>
                        <td>{{ $carrera->nombre }}</td>
                        <td>{{ $carrera->creditajeadmision ?? '-' }}</td>
                        <td>{{ $carrera->regimen ?? '-' }}</td>
                        <td>{{ $carrera->nivelacademico ?? '-' }}</td>
                        <td class="text-center">{{ $carrera->version ?? '-' }}</td>
                        <td class="text-center">{{ $carrera->resolucionministerial1 ?? '-' }}</td>
                        <td class="text-center">{{ $carrera->resolucionministerial2 ?? '-' }}</td>
                        <td class="text-center">{{ $carrera->resolucionministerial3 ?? '-' }}</td>
                        <td class="text-center">{{ $carrera->creditajematricula ?? '-' }}</td>
                        @php($jefeCarrera = $carrera->jefeCarrera?->persona)
                        <td>{{ $jefeCarrera ? trim($jefeCarrera->nombre . ' ' . $jefeCarrera->primerapellido . ' ' . ($jefeCarrera->segundoapellido ?? '')) : '-' }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('planes.carreras.edit', $carrera->id_carrera) }}" class="btn btn-sm btn-info" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('planes.carreras.materias.import', $carrera->id_carrera) }}" class="btn btn-sm btn-success" title="Cargar materias">
                                    <i class="fas fa-file-upload"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="text-center text-muted py-3">No hay carreras registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop