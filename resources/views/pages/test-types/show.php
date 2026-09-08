@extends('layouts.app')

@section('title', $testType['name'] . ' - Test Type Detail')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Test Types', 'url' => route('test-types.index')], ['label' => $testType['name'], 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1>{{ $testType['name'] }}</h1>
                <p>{{ $testType['description'] ?? 'Practice MCQs and prepare for ' . $testType['name'] . '.' }}</p>
                <div class="d-flex gap-2 flex-wrap mt-3">
                    <a href="{{ route('subjects.index') }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practicing</a>
                    <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-outline-light btn-lg"><i class="bi bi-clipboard-check me-2"></i>Mock Tests</a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi <?= htmlspecialchars($testType['icon'] ?? 'bi-diagram-3') ?>-fill" style="font-size:6rem;color:rgba(245,166,35,0.3);"></i>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $mcqCount }}">0</div><div class="sk-stat-label">Total MCQs</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ count($relatedSubjects) }}">0</div><div class="sk-stat-label">Subjects</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $topicCount }}">0</div><div class="sk-stat-label">Topics</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $mockTestCount }}">0</div><div class="sk-stat-label">Mock Tests</div></div></div>
        </div>
    </div>
</section>

<section class="sk-section bg-soft">
    <div class="container">
        <h2 class="sk-section-title">Related Subjects</h2>
        <p class="sk-section-subtitle">Subjects covered in {{ $testType['name'] }}</p>
        @if(count($relatedSubjects) > 0)
        <div class="row g-4">
            @foreach($relatedSubjects as $subject)
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('test-types.subject', [$testType['slug'], $subject['slug']]) }}" class="sk-card text-decoration-none">
                    <div class="sk-card-icon <?= htmlspecialchars($subject['icon_bg'] ?? 'bg-icon-navy') ?>"><i class="bi <?= htmlspecialchars($subject['icon'] ?? 'bi-journal') ?>"></i></div>
                    <h3 class="sk-card-title">{{ $subject['name'] }}</h3>
                    <p class="sk-card-text">{{ mb_strimwidth($subject['description'] ?? '', 0, 60, '...') }}</p>
                    <div class="sk-card-meta"><span><i class="bi bi-collection"></i> {{ $subject['mcq_count'] }} MCQs</span></div>
                    <span class="btn btn-sk-outline btn-sm-sk w-100">Practice <i class="bi bi-arrow-right ms-1"></i></span>
                </a>
            </div>
            @endforeach
        </div>
        @else
        @include('components.empty-state', ['icon' => 'bi-journals', 'title' => 'No subjects linked yet', 'message' => 'Subjects covered by this test type will show up here.'])
        @endif
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <h2 class="sk-section-title">Popular Topics</h2>
        <p class="sk-section-subtitle">Most practiced {{ $testType['name'] }} topics</p>
        @if(count($popularTopics) > 0)
        <div class="row g-3">
            @foreach($popularTopics as $topic)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('topics.show', $topic['slug']) }}" class="sk-list-item text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <div class="sk-card-icon bg-icon-navy mb-0"><i class="bi <?= htmlspecialchars($topic['icon'] ?? 'bi-journal') ?>"></i></div>
                        <div>
                            <div class="fw-semibold text-dark-navy">{{ $topic['name'] }}</div>
                            <small class="text-secondary-custom">{{ $topic['subject_name'] }} &middot; {{ $topic['mcq_count'] }} MCQs</small>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted"></i>
                </a>
            </div>
            @endforeach
        </div>
        @else
        @include('components.empty-state', ['icon' => 'bi-list-ul', 'title' => 'No topics yet', 'message' => 'Topics for this test type\'s subjects will show up here.'])
        @endif
    </div>
</section>

<section class="sk-section bg-soft">
    <div class="container">
        <h2 class="sk-section-title">Available Practice Sections</h2>
        <p class="sk-section-subtitle">Choose how you want to practice</p>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="sk-card">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="sk-card-icon bg-icon-navy mb-0"><i class="bi bi-collection-play"></i></div>
                        <div><h4 class="mb-0">Topic-wise Practice</h4><small class="text-secondary-custom">Practice MCQs by specific topic</small></div>
                    </div>
                    <p class="sk-card-text mt-2">Select individual topics and practice MCQs one by one with instant feedback and explanations.</p>
                    @if(count($relatedSubjects) > 0)
                    <a href="{{ route('test-types.subject', [$testType['slug'], $relatedSubjects[0]['slug']]) }}" class="btn btn-sk-navy btn-sm-sk w-100">Start Topic Practice</a>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="sk-card">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="sk-card-icon bg-icon-gold mb-0"><i class="bi bi-clipboard2-check"></i></div>
                        <div><h4 class="mb-0">Full Mock Tests</h4><small class="text-secondary-custom">Timed exam simulation</small></div>
                    </div>
                    <p class="sk-card-text mt-2">Take full-length {{ $testType['name'] }} mock tests with a timer, question palette, and detailed results.</p>
                    <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-gold btn-sm-sk w-100">Browse Mock Tests</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sk-section bg-dark-navy text-white" style="padding:3rem 0;">
    <div class="container text-center">
        <h2 class="text-white mb-2">Ready to Ace {{ $testType['name'] }}?</h2>
        <p class="mb-4" style="color:rgba(255,255,255,0.8);">Start practicing now and track your improvement.</p>
        @if(count($relatedSubjects) > 0)
        <a href="{{ route('test-types.subject', [$testType['slug'], $relatedSubjects[0]['slug']]) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practicing</a>
        @endif
    </div>
</section>
@endsection
