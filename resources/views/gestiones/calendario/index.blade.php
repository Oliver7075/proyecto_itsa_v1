@extends('adminlte::page')

@section('title', 'Calendario Académico')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Encabezado -->
    <div class="d-flex align-items-baseline mb-3">
        <h4 class="text-secondary fw-normal mb-0 me-2" style="font-size: 1.5rem; color: #555;">Calendario Academico</h4>
        <small class="text-muted" style="font-size: 0.9rem;">gestion del calendario academico</small>
    </div>

    <!-- Contenedor Principal -->
    <div class="card border rounded-1 p-3 bg-white" style="border-color: #dcdcdc !important;">
        
        <!-- Filtro por Gestión Académica -->
        <form action="{{ route('admin.actividad.index') }}" method="GET" id="filterForm">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="id_gestionacademica" class="form-label text-secondary mb-1" style="font-size: 0.9rem;">
                        Gestión academica: <span class="text-danger">*</span>
                    </label>
                    <select name="id_gestionacademica" id="id_gestionacademica" class="form-select form-select-sm shadow-none" style="border-color: #ccc;" onchange="document.getElementById('filterForm').submit();">
                        <option value="">-- Seleccionar --</option>
                        @foreach($gestiones as $gestion)
                            <option value="{{ $gestion->id_gestionacademica }}" {{ request('id_gestionacademica') == $gestion->id_gestionacademica ? 'selected' : '' }}>
                                {{ $gestion->gestion }} - Periodo {{ $gestion->periodo }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Toolbar (Botones) -->
            <div class="d-flex justify-content-between align-items-center bg-light border p-1 rounded-1 mb-3" style="background-color: #f5f5f5 !important;">
                <div>
                    <a href="{{ route('admin.actividad.create', ['id_gestionacademica' => request('id_gestionacademica')]) }}" class="btn btn-sm btn-light border px-3 me-1 shadow-sm" style="background-color: #fafafa; font-size: 0.85rem;">
                        <i class="fas fa-plus text-secondary"></i> + Nuevo
                    </a>
                    <button type="button" class="btn btn-sm btn-light border px-3 shadow-sm" onclick="window.location.reload();" style="background-color: #fafafa; font-size: 0.85rem;">
                        <i class="fas fa-sync-alt text-secondary"></i> Actualizar
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-light border shadow-sm" style="background-color: #fafafa;">
                        <i class="fas fa-cog text-secondary"></i>
                    </button>
                </div>
            </div>

            <!-- Buscador -->
            <div class="input-group input-group-sm mb-3">
                <input type="text" name="buscar" class="form-control shadow-none" placeholder="" value="{{ request('buscar') }}" style="border-color: #ccc;">
                <button class="btn btn-light border shadow-none px-3" type="submit" style="border-color: #ccc; background-color: #f8f9fa;">
                    <i class="fas fa-search text-secondary"></i>
                </button>
            </div>
        </form>

        <!-- Tabla de Actividades del Calendario -->
        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center align-middle mb-0" style="font-size: 0.88rem; border-color: #e0e0e0;">
                <thead style="background-color: #f2f2f2;">
                    <tr class="text-secondary fw-bold">
                        <th style="width: 50px;">Nº</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Funcionalidad</th>
                        <th>Habilitado para</th>
                        <th style="width: 80px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($actividades as $actividad)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $actividad->inicio ? \Carbon\Carbon::parse($actividad->inicio)->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $actividad->fin ? \Carbon\Carbon::parse($actividad->fin)->format('d/m/Y H:i') : '-' }}</td>
                            <td class="text-start ps-2">{{ $actividad->nombre }}</td>
                            <td class="text-start ps-2">{{ $actividad->descripcion ?? '-' }}</td>
                            <td>{{ $actividad->funcionalidad ?? '-' }}</td>
                            <td>
                                @if($actividad->carreras->isNotEmpty())
                                    Por carrera
                                @elseif($actividad->usuarios->isNotEmpty())
                                    Por usuario
                                @else
                                    General
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.actividad.edit', $actividad->id_actividad) }}" class="btn btn-xs btn-link p-0 me-1"><i class="fas fa-edit text-primary"></i></a>
                                <form action="{{ route('admin.actividad.destroy', $actividad->id_actividad) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-link p-0 text-danger" onclick="return confirm('¿Eliminar actividad?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-start ps-3 py-2 text-muted" style="background-color: #fff;">
                                Ningún registro encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection