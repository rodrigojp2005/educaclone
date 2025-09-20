@extends('admin.base')

@section('title', 'Cursos')
@section('page-title', 'Cursos')

@section('page-actions')
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Novo Curso
    </a>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por título ou descrição">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Todos status</option>
                    @foreach(['draft'=>'Rascunho','published'=>'Publicado','archived'=>'Arquivado'] as $val=>$label)
                        <option value="{{ $val }}" @selected(request('status')===$val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">Todas categorias</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="instructor_id" class="form-select">
                    <option value="">Todos instrutores</option>
                    @foreach($instructors as $inst)
                        <option value="{{ $inst->id }}" @selected(request('instructor_id')==$inst->id)>{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-outline-secondary w-100" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Instrutor</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Preço</th>
                        <th>Publicado em</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->instructor?->name }}</td>
                            <td>{{ $course->category?->name }}</td>
                            <td><span class="badge bg-{{ $course->status==='published'?'success':($course->status==='draft'?'secondary':'dark') }}">{{ ucfirst($course->status) }}</span></td>
                            <td>
                                @if($course->is_free)
                                    <span class="badge bg-success">Gratuito</span>
                                @else
                                    R$ {{ number_format($course->discount_price ?? $course->price, 2, ',', '.') }}
                                @endif
                            </td>
                            <td>{{ $course->published_at?->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este curso?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Nenhum curso encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $courses->links() }}
    </div>
</div>
@endsection
