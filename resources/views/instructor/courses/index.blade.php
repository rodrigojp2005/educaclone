@extends('instructor.layout')

@section('instructor-page-title','Meus Cursos')

@section('page-actions')
    <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Novo Curso
    </a>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Preço</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->category?->name }}</td>
                            <td><span class="badge bg-{{ $course->status==='published'?'success':($course->status==='draft'?'secondary':'dark') }}">{{ ucfirst($course->status) }}</span></td>
                            <td>
                                @if($course->is_free)
                                    <span class="badge bg-success">Gratuito</span>
                                @else
                                    R$ {{ number_format($course->discount_price ?? $course->price, 2, ',', '.') }}
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('instructor.courses.lessons.index', $course) }}" class="btn btn-sm btn-outline-secondary">Aulas</a>
                                <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('instructor.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este curso?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Nenhum curso encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $courses->links() }}
    </div>
</div>
@endsection
