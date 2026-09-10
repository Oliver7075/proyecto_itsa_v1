@extends('adminlte::page')

@section('title', 'Gestiones Académicas')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Encabezado de la página -->
    <div class="d-flex align-items-baseline mb-3">
        <h4 class="text-secondary fw-normal mb-0 me-2" style="font-size: 1.5rem; color: #555;">Gestiones Académicas</h4>
        <small class="text-muted" style="font-size: 0.9rem;">administración de gestiones académicas</small>
    </div>

    <!-- Panel Principal -->
    <div class="card border rounded-1 p-3 bg-white" style="border-color: #dcdcdc !important;">
        
        <!-- Filtro por Regimen -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="regimen" class="form-label text-secondary mb-1" style="font-size: 0.9rem;">
                    Regimen: <span class="text-danger">*</span>
                </label>
                <select name="regimen" id="regimen" class="form-select form-select-sm shadow-none" style="border-color: #ccc;">
                    <option value="">-- Seleccionar --</option>
                    <option value="1">Anual</option>
                    <option value="2">Semestral</option>
                </select>
            </div>
        </div>

        <!-- Barra de Herramientas (Botones) -->
        <div class="d-flex justify-content-between align-items-center bg-light border p-1 rounded-1 mb-3" style="background-color: #f5f5f5 !important;">
            <div>
                <a href="{{ route('admin.gestionacademica.create') }}" class="btn btn-sm btn-light border px-3 me-1 shadow-sm" style="background-color: #fafafa; font-size: 0.85rem;">
                    <i class="fas fa-plus text-secondary"></i> + Nuevo
                </a>
                <button type="button" class="btn btn-sm btn-light border px-3 shadow-sm" onclick="window.location.reload();" style="background-color: #fafafa; font-size: 0.85rem;">
                    <i class="fas fa-sync-alt text-secondary"></i> Actualizar
                </button>
            </div>
            <div>
                <button class="btn btn-sm btn-light border shadow-sm" style="background-color: #fafafa;">
                    <i class="fas fa-cog text-secondary"></i>
                </button>
            </div>
        </div>

        <!-- Buscador -->
        <form action="{{ route('admin.gestionacademica.index') }}" method="GET" class="mb-3">
            <div class="input-group input-group-sm">
                <input type="text" name="buscar" class="form-control shadow-none" placeholder="" value="{{ request('buscar') }}" style="border-color: #ccc;">
                <button class="btn btn-light border shadow-none px-3" type="submit" style="border-color: #ccc; background-color: #f8f9fa;">
                    <i class="fas fa-search text-secondary"></i>
                </button>
            </div>
        </form>

        <!-- Tabla de Datos -->
        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center align-middle mb-0" style="font-size: 0.88rem; border-color: #e0e0e0;">
                <thead style="background-color: #f2f2f2;">
                    <tr class="text-secondary fw-bold">
                        <th style="width: 50px;">Nº</th>
                        <th>Codigo</th>
                        <th>Gestión</th>
                        <th>Periodo</th>
                        <th>Regimen</th>
                        <th>Modalidad Evaluación</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Vigente</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gestiones as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id_gestionacademica }}</td>
                            <td>{{ $item->gestion }}</td>
                            <td>{{ $item->periodo }}</td>
                            <td>{{ $item->regimen }}</td>
                            <td>{{ $item->modalidadevaluacion }}</td>
                            <td>{{ $item->inicio ? \Carbon\Carbon::parse($item->inicio)->format('d/m/Y') : '-' }}</td>
                            <td>{{ $item->fin ? \Carbon\Carbon::parse($item->fin)->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($item->vigente)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-start ps-3 py-2 text-muted" style="background-color: #fff;">
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