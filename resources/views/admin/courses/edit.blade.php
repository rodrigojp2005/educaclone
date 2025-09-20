@extends('admin.base')

@section('title', 'Editar Curso')
@section('page-title', 'Editar Curso')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="row g-3">
            @csrf
            @method('PUT')
            <div class="col-md-8">
                <label class="form-label">Título</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nível</label>
                <select name="level" class="form-select">
                    @foreach(['beginner'=>'Iniciante','intermediate'=>'Intermediário','advanced'=>'Avançado'] as $val=>$label)
                        <option value="{{ $val }}" @selected(old('level',$course->level)===$val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label">Descrição curta</label>
                <input type="text" name="short_description" value="{{ old('short_description', $course->short_description) }}" class="form-control">
            </div>
            <div class="col-md-12">
                <label class="form-label">Descrição</label>
                <textarea name="description" rows="5" class="form-control">{{ old('description', $course->description) }}</textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label">Preço</label>
                <input type="number" name="price" value="{{ old('price', $course->price) }}" step="0.01" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Preço promocional</label>
                <input type="number" name="discount_price" value="{{ old('discount_price', $course->discount_price) }}" step="0.01" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id', $course->category_id)==$cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Instrutor</label>
                <select name="instructor_id" class="form-select" required>
                    @foreach($instructors as $inst)
                        <option value="{{ $inst->id }}" @selected(old('instructor_id', $course->instructor_id)==$inst->id)>{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    @foreach(['draft'=>'Rascunho','published'=>'Publicado','archived'=>'Arquivado'] as $val=>$label)
                        <option value="{{ $val }}" @selected(old('status',$course->status)===$val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Idioma</label>
                <input type="text" name="language" value="{{ old('language', $course->language) }}" class="form-control">
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Destaque</label>
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_free" name="is_free" value="1" {{ old('is_free', $course->is_free) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_free">Gratuito</label>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>
</div>
@endsection
