@extends('instructor.layout')

@section('instructor-page-title', 'Aulas')

@section('page-actions')
    <a href="{{ route('instructor.courses.lessons.create', $course) }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Nova Aula
    </a>
@endsection

@section('content')
<div class="mb-3">
    <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-link">« Voltar ao curso</a>
    <h5 class="mt-2">{{ $course->title }}</h5>
    <div class="text-muted">Gerencie as aulas deste curso</div>
    <hr>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Provider</th>
                    <th>Publicado</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->sort_order }}</td>
                        <td>{{ $lesson->title }}</td>
                        <td>{{ ucfirst($lesson->type) }}</td>
                        <td>{{ $lesson->provider ?: '-' }}</td>
                        <td>
                            @if($lesson->is_published)
                                <span class="badge bg-success">Sim</span>
                            @else
                                <span class="badge bg-secondary">Não</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('instructor.courses.lessons.edit', [$course, $lesson]) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('instructor.courses.lessons.destroy', [$course, $lesson]) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir esta aula?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Nenhuma aula cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $lessons->links() }}
</div>
@endsection
