@extends('adminlte::page')

@section('title', 'Configuración')

@section('content_header')
    <h1>Configuración del Instituto</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Datos Generales</h3>
    </div>
    <form action="{{ route('admin.instituto.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control">
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre regulador *</label>
                        <input type="text" name="nombre_regulador" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ubicación *</label>
                        <input type="text" name="ubicacion" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Carácter *</label>
                        <select name="caracter" class="form-control" required>
                            <option value="FISCAL">FISCAL</option>
                            <option value="PRIVADO">PRIVADO</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombre impuestos</label>
                        <input type="text" name="nombre_impuestos" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>NIT</label>
                        <input type="text" name="nit" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Actividad económica</label>
                        <input type="text" name="actividad_economica" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Precio crédito *</label>
                        <input type="number" name="precio_credito" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Resolución ministerial *</label>
                        <input type="text" name="resolucion_ministerial" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Abreviatura *</label>
                        <input type="text" name="abreviatura" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Token</label>
                        <input type="text" name="token_middleware" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="#" class="btn btn-default">Cancelar</a>
        </div>
    </form>
</div>
@stop