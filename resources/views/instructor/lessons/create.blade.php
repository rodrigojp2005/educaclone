@extends('instructor.layout')

@section('instructor-page-title','Nova Aula')

@section('content')
<div class="mb-3">
    <a href="{{ route('instructor.courses.lessons.index', $course) }}" class="btn btn-link">« Voltar</a>
    <h5 class="mt-2">Curso: {{ $course->title }}</h5>
</div>

<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('instructor.courses.lessons.store', $course) }}" class="row g-3">
            @csrf
            <div class="col-md-8">
                <label class="form-label">Título</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Ordem</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-control" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipo</label>
                <select name="type" id="type" class="form-select">
                    <option value="video">Vídeo</option>
                    <option value="text">Texto</option>
                    <option value="quiz">Quiz</option>
                    <option value="file">Arquivo</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Provider (para vídeo)</label>
                <select name="provider" id="provider" class="form-select">
                    <option value="youtube">YouTube</option>
                    <option value="cloudflare">Cloudflare Stream</option>
                    <option value="bunny">Bunny</option>
                    <option value="url">URL direta</option>
                </select>
                <div class="form-text">Recomendado: escolha YouTube e cole o ID ou link (watch, youtu.be, embed). Se colar um link do YouTube em “URL direta”, converteremos automaticamente para YouTube.</div>
            </div>
            <div class="col-md-4">
                <label class="form-label">YouTube ID/URL ou UID do Provider</label>
                <input type="text" name="video_input" value="{{ old('video_input') }}" class="form-control" placeholder="Ex: dQw4w9WgXcQ ou https://youtu.be/dQw4...">
                <div class="form-text">Aceita formatos: ID puro, https://youtu.be/ID, https://www.youtube.com/watch?v=ID, ou /embed/ID.</div>
            </div>
            <div class="col-md-12">
                <label class="form-label">URL do Vídeo (se URL direta)</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}" class="form-control" placeholder="https://...">
                <div class="form-text">Use apenas arquivos diretos (mp4/HLS). Se colar um link do YouTube aqui, detectaremos o ID e mudaremos o provider para YouTube automaticamente.</div>
            </div>
            <div class="col-md-12">
                <label class="form-label">Descrição/Conteúdo</label>
                <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label">Duração (min)</label>
                <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" class="form-control" min="0">
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_free" name="is_free" value="1" @checked(old('is_free'))>
                <label class="form-check-label" for="is_free">Aula gratuita (amostra)</label>
            </div>
            <div class="col-md-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" @checked(old('is_published', true))>
                <label class="form-check-label" for="is_published">Publicada</label>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a href="{{ route('instructor.courses.lessons.index', $course) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
 </div>
@endsection
