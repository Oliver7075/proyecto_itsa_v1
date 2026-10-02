@extends('adminlte::page')

@section('title', 'Materias')

@section('content')
<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Materias</h3>
        <a href="{{ route('planes.materias.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nueva materia
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Créditos</th>
                    <th>Nivel</th>
                    <th>Horas</th>
                    <th>Prerrequisitos</th>
                    <th style="width: 140px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materias as $materia)
                    <tr>
                        <td>{{ $materia->codigo ?? '-' }}</td>
                        <td>{{ $materia->nombre }}</td>
                        <td>{{ $materia->carrera->nombre ?? 'Sin carrera' }}</td>
                        <td>{{ $materia->creditajemateria ?? '-' }}</td>
                        <td>{{ $materia->nivel ?? '-' }}</td>
                        <td>{{ $materia->horas ?? '-' }}</td>
                        <td>
                            @if($materia->prerequisitos->isNotEmpty())
                                @foreach($materia->prerequisitos as $prereq)
                                    <span class="badge badge-secondary mr-1">{{ $prereq->nombre }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Sin prerequisitos</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('planes.materias.edit', $materia->id_materia) }}" class="btn btn-sm btn-info" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('planes.materias.destroy', $materia->id_materia) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta materia?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No hay materias registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
