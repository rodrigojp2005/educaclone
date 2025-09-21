@extends('admin.layout')

@section('title', 'Editar Usuário')
@section('page-title', 'Editar Usuário')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="row g-3">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label class="form-label">Nome</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Nova Senha (opcional)</label>
                <input type="password" name="password" class="form-control">
                @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Papel</label>
                <select name="role" class="form-select" required>
                    <option value="admin" @selected(old('role', $user->role)==='admin')>Administrador</option>
                    <option value="instructor" @selected(old('role', $user->role)==='instructor')>Instrutor</option>
                    <option value="student" @selected(old('role', $user->role)==='student')>Estudante</option>
                </select>
                @error('role')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 form-check mt-4">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Ativo</label>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>
@endsection
