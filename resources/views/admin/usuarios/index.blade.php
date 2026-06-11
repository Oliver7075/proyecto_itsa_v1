@extends('adminlte::page')
<div class="card">
    <div class="card-header">
        <form action="{{ route('admin.usuarios.index') }}" method="GET">
            <div class="row">
                <div class="col-md-6">
                    <label>Rol:</label>
                    <select name="role_id" class="form-control" onchange="this.form.submit()">
                        <option value="">TODOS LOS ROLES</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Buscar:</label>
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
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Usuario</th>
                    <th>Roles</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->persona->primerapellido }}</td>
                    <td>{{ $user->persona->nombre }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                        <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-key"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }} </div>
</div>