@extends('admin.base')

@section('title', 'Nova Categoria')
@section('page-title', 'Nova Categoria')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label class="form-label">Nome</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Descrição</label>
                <input type="text" name="description" value="{{ old('description') }}" class="form-control">
                @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Ícone (FA class)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="form-control" placeholder="ex: fas fa-code">
                @error('icon')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Cor</label>
                <input type="text" name="color" value="{{ old('color', '#007bff') }}" class="form-control">
                @error('color')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Ordem</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-control">
                @error('sort_order')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-12 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                <label class="form-check-label" for="is_active">Ativa</label>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
