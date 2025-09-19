@extends('layout')

@section('title', $course->title)

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-2">{{ $course->title }}</h1>
            <div class="mb-3 text-muted">Por <strong>{{ $course->instructor->name }}</strong> • {{ ucfirst($course->level) }} • {{ $course->language }}</div>
            <div class="d-flex align-items-center mb-3">
                @php $rating = $course->average_rating; @endphp
                <span class="text-warning me-2">
                    @for($i=1;$i<=5;$i++)
                        @if($i <= $rating) ★ @else ☆ @endif
                    @endfor
                </span>
                <small class="text-muted">{{ number_format($rating,1) }} ({{ $course->reviews->count() }} avaliações)</small>
            </div>
            <p class="lead">{{ $course->short_description }}</p>

            <div class="mb-4">
                @if($enrolled)
                    <a href="#lesson-{{ $nextLessonId ?? '' }}" class="btn btn-success me-2">Continuar Curso</a>
                @else
                    <form method="POST" action="{{ route('courses.enroll', $course->slug) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-primary me-2">Matricular-se
                            @if(!$course->is_free)
                                - @if($course->discount_price)
                                    R$ {{ number_format($course->discount_price,2,',','.') }}
                                @else
                                    R$ {{ number_format($course->price,2,',','.') }}
                                @endif
                            @else (Gratuito) @endif
                        </button>
                    </form>
                @endif
            </div>

            <h4 class="mt-5" id="learn">O que você aprenderá</h4>
            <ul class="list-unstyled bg-light p-3 rounded">
                @forelse(($course->what_you_learn ?? []) as $item)
                    <li class="mb-1">✅ {{ $item }}</li>
                @empty
                    <li class="text-muted">(Não informado)</li>
                @endforelse
            </ul>

            <h4 class="mt-4" id="requirements">Requisitos</h4>
            <ul class="list-unstyled bg-light p-3 rounded">
                @forelse(($course->requirements ?? []) as $item)
                    <li class="mb-1">• {{ $item }}</li>
                @empty
                    <li class="text-muted">(Nenhum requisito específico)</li>
                @endforelse
            </ul>

            <h4 class="mt-5" id="curriculum">Currículo</h4>
            <div class="accordion" id="lessonsAccordion">
                @forelse($course->lessons as $lesson)
                    <div class="accordion-item" id="lesson-{{ $lesson->id }}">
                        <h2 class="accordion-header" id="heading-{{ $lesson->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $lesson->id }}" aria-expanded="false" aria-controls="collapse-{{ $lesson->id }}">
                                <div class="d-flex align-items-center w-100">
                                    <span class="me-2 badge bg-secondary">{{ strtoupper(substr($lesson->type,0,1)) }}</span>
                                    <span class="flex-grow-1">{{ $lesson->title }}</span>
                                    <small class="text-muted ms-2">{{ $lesson->formatted_duration }}</small>
                                    @if($lesson->is_free)
                                        <span class="ms-2 badge bg-success">Preview</span>
                                    @endif
                                    @if(!empty($completedLessonIds) && in_array($lesson->id, $completedLessonIds))
                                        <span class="ms-2 badge bg-primary">Concluída</span>
                                    @endif
                                </div>
                            </button>
                        </h2>
                        <div id="collapse-{{ $lesson->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $lesson->id }}" data-bs-parent="#lessonsAccordion">
                            <div class="accordion-body">
                                @if(!$enrolled && !$lesson->is_free)
                                    <div class="alert alert-warning mb-0">Faça a matrícula para acessar o conteúdo desta aula.</div>
                                @else
                                    @if($lesson->isVideo() && $lesson->video_source)
                                        <div class="ratio ratio-16x9 mb-3">
                                            <iframe src="{{ $lesson->video_source }}" title="Vídeo" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    @endif
                                    @if($lesson->isText())
                                        <div class="mb-3">{!! nl2br(e($lesson->content)) !!}</div>
                                    @endif
                                    @if($lesson->isFile() && $lesson->file_url)
                                        <a href="{{ $lesson->file_url }}" target="_blank" class="btn btn-outline-secondary btn-sm mb-3">Baixar arquivo</a>
                                    @endif
                                    @if($enrolled)
                                        @php $isCompleted = !empty($completedLessonIds) && in_array($lesson->id, $completedLessonIds); @endphp
                                        <button class="btn btn-sm toggle-progress-btn {{ $isCompleted ? 'btn-success' : 'btn-outline-primary' }}" data-lesson="{{ $lesson->slug }}" data-id="{{ $lesson->id }}">
                                            {{ $isCompleted ? 'Concluída ✓' : 'Marcar como Concluída' }}
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Nenhuma aula cadastrada.</p>
                @endforelse
            </div>

            <h4 class="mt-5" id="reviews">Avaliações</h4>
            <div class="mb-4">
                @forelse($course->reviews as $review)
                    <div class="border rounded p-3 mb-2">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name }}</strong>
                            <span class="text-warning">{!! str_repeat('★',$review->rating) . str_repeat('☆',5-$review->rating) !!}</span>
                        </div>
                        @if($review->comment)
                            <p class="mb-1">{{ $review->comment }}</p>
                        @endif
                        <small class="text-muted">{{ $review->reviewed_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <p class="text-muted">Ainda não há avaliações.</p>
                @endforelse
            </div>

            @auth
                @if($enrolled && !$course->reviews->where('user_id', auth()->id())->count())
                    <div class="card mb-5">
                        <div class="card-body">
                            <h5 class="card-title">Avaliar Curso</h5>
                            <form method="POST" action="{{ route('courses.reviews.store', $course->slug) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Nota (1 a 5)</label>
                                    <select name="rating" class="form-select" required>
                                        <option value="">Selecione</option>
                                        @for($i=1;$i<=5;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Comentário (opcional)</label>
                                    <textarea name="comment" rows="3" class="form-control" maxlength="2000"></textarea>
                                </div>
                                <button class="btn btn-primary">Enviar Avaliação</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Informações</h5>
                    <ul class="list-unstyled mb-0 small">
                        <li><strong>Status:</strong> {{ ucfirst($course->status) }}</li>
                        <li><strong>Duração Total:</strong> {{ $course->duration_minutes }} min</li>
                        <li><strong>Lições:</strong> {{ $course->lessons->count() }}</li>
                        <li><strong>Alunos:</strong> {{ $course->students_count }}</li>
                        <li><strong>Última Atualização:</strong> {{ $course->updated_at->format('d/m/Y') }}</li>
                    </ul>
                </div>
            </div>
            @if($course->thumbnail)
                <img src="{{ $course->thumbnail }}" class="img-fluid rounded mb-4" alt="{{ $course->title }}">
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.toggle-progress-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const slug = this.dataset.lesson;
            fetch(`/lessons/${slug}/toggle-progress`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.completed !== undefined) {
                    this.classList.toggle('btn-outline-primary', !data.completed);
                    this.classList.toggle('btn-success', data.completed);
                    this.textContent = data.completed ? 'Concluída ✓' : 'Marcar como Concluída';
                    // Atualiza badge no header da aula
                    const header = this.closest('.accordion-item').querySelector('.accordion-button .d-flex');
                    if (header) {
                        let badge = header.querySelector('.badge.bg-primary');
                        if (data.completed && !badge) {
                            const span = document.createElement('span');
                            span.className = 'ms-2 badge bg-primary';
                            span.textContent = 'Concluída';
                            header.appendChild(span);
                        }
                        if (!data.completed && badge) {
                            badge.remove();
                        }
                    }
                }
            })
            .catch(err => console.error(err));
        });
    });

    // Abre automaticamente a próxima aula sem "toggle" duplo (usa API do Bootstrap)
    document.addEventListener('DOMContentLoaded', function() {
        const targetId = '{{ $nextLessonId ?? '' }}';
        if (targetId) {
            const collapseEl = document.getElementById('collapse-' + targetId);
            if (collapseEl && window.bootstrap && window.bootstrap.Collapse) {
                const instance = window.bootstrap.Collapse.getOrCreateInstance(collapseEl, { toggle: false });
                instance.show();
                // Rolagem suave até a aula atual
                const lessonAnchor = document.getElementById('lesson-' + targetId);
                if (lessonAnchor) {
                    lessonAnchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        }
    });
</script>
@endsection
