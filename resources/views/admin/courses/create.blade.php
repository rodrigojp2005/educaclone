@extends('admin.base')

@section('title', 'Novo Curso')
@section('page-title', 'Novo Curso')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.courses.store') }}" class="row g-3">
            @csrf
            <div class="col-md-8">
                <label class="form-label">Título</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Nível</label>
                <select name="level" class="form-select">
                    <option value="beginner" @selected(old('level')==='beginner')>Iniciante</option>
                    <option value="intermediate" @selected(old('level')==='intermediate')>Intermediário</option>
                    <option value="advanced" @selected(old('level')==='advanced')>Avançado</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">Descrição curta</label>
                <input type="text" name="short_description" value="{{ old('short_description') }}" class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">Descrição</label>
                <textarea name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label">Preço</label>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Preço promocional</label>
                <input type="number" name="discount_price" value="{{ old('discount_price') }}" step="0.01" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id')==$cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Instrutor</label>
                <select name="instructor_id" class="form-select" required>
                    @foreach($instructors as $inst)
                        <option value="{{ $inst->id }}" @selected(old('instructor_id')==$inst->id)>{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="draft" @selected(old('status')==='draft')>Rascunho</option>
                    <option value="published" @selected(old('status')==='published')>Publicado</option>
                    <option value="archived" @selected(old('status')==='archived')>Arquivado</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Idioma</label>
                <input type="text" name="language" value="{{ old('language','pt') }}" class="form-control">
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" @checked(old('is_featured'))>
                <label class="form-check-label" for="is_featured">Destaque</label>
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_free" name="is_free" value="1" @checked(old('is_free'))>
                <label class="form-check-label" for="is_free">Gratuito</label>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
