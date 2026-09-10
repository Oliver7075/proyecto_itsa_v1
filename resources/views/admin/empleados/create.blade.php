@extends('adminlte::page')

@section('content')
<div class="container-fluid pt-3">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Registro de Nuevo Empleado</h3>
        </div>
        
        <form action="{{ route('admin.empleados.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group">
                        <label>foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Nombre *</label>
                        <input type="text" name="nombre" class="form-control" required placeholder="Ej. Juan">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Primer Apellido *</label>
                        <input type="text" name="primerapellido" class="form-control" required placeholder="Ej. Pérez">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Segundo Apellido</label>
                        <input type="text" name="segundoapellido" class="form-control" placeholder="Ej. Gómez">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>DNI *</label>
                        <input type="text" name="dni" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Lugar Expedición *</label>
                        <input type="text" name="lugarexpedicion" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Fecha Nacimiento *</label>
                        <input type="date" name="fechanacimiento" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Lugar Nacimiento *</label>
                        <input type="text" name="lugarnacimiento" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Nacionalidad *</label>
                        <input type="text" name="nacionalidad" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Sexo *</label>
                        <select name="sexo" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <option value="MASCULINO">Masculino</option>
                            <option value="FEMENINO">Femenino</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Dirección *</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Celular</label>
                        <input type="text" name="celular" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Email *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Abreviatura Profesión *</label>
                        <input type="text" name="abreviaturaprofesion" class="form-control" required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Código</label>
                        <input type="text" name="codigo" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Rol *</label>
                        <select name="id_rol" class="form-control" required>
                            <option value="">Seleccione un rol</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->id_rol }}">{{ $rol->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Empleado</button>
            </div>
        </form>
    </div>
</div>
@stop