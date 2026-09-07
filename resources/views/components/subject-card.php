<div class="sk-card">
    <div class="sk-card-icon {{ $icon_bg }}"><i class="bi {{ $icon }}"></i></div>
    <h3 class="sk-card-title">{{ $name }}</h3>
    <p class="sk-card-text">{{ $description }}</p>
    <div class="sk-card-meta">
        <span><i class="bi bi-list-ul"></i> {{ $topics }} Topics</span>
        <span><i class="bi bi-collection"></i> {{ $mcqs }} MCQs</span>
    </div>
    <a href="{{ route('subjects.show', $slug) }}" class="btn btn-sk-outline btn-sm-sk w-100">Explore <i class="bi bi-arrow-right ms-1"></i></a>
</div>