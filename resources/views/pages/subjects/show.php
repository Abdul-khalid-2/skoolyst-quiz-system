@extends('layouts.app')

@section('title', $subject['name'] . ' - Subject Detail')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Subjects', 'url' => route('subjects.index')], ['label' => $subject['name'], 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1>{{ $subject['name'] }}</h1>
                <p>{{ $subject['description'] ?? 'Practice MCQs and sharpen your understanding of ' . $subject['name'] . '.' }}</p>
                <div class="d-flex gap-2 flex-wrap mt-3">
                    @if(count($relatedTestTypes) > 0)
                    <a href="{{ route('test-types.subject', [$relatedTestTypes[0]['slug'], $subject['slug']]) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
                    @endif
                    <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-outline-light btn-lg"><i class="bi bi-clipboard-check me-2"></i>Mock Tests</a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi <?= htmlspecialchars($subject['icon'] ?? 'bi-journal') ?>" style="font-size:6rem;color:rgba(22,163,74,0.3);"></i>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $mcqCount }}">0</div><div class="sk-stat-label">Total MCQs</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $topicCount }}">0</div><div class="sk-stat-label">Topics</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ count($relatedTestTypes) }}">0</div><div class="sk-stat-label">Test Types</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $mockTestCount }}">0</div><div class="sk-stat-label">Mock Tests</div></div></div>
        </div>
    </div>
</section>

<section class="sk-section bg-soft">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <h2 class="sk-section-title">Topics</h2>
                <p class="sk-section-subtitle">Practice MCQs by specific topic</p>
                @if(count($topics) > 0)
                <div class="row g-3">
                    @foreach($topics as $topic)
                    <div class="col-md-6">
                        <a href="{{ route('topics.show', $topic['slug']) }}" class="sk-list-item text-decoration-none">
                            <div class="d-flex align-items-center gap-3">
                                <div class="sk-card-icon <?= htmlspecialchars($subject['icon_bg'] ?? 'bg-icon-navy') ?> mb-0"><i class="bi <?= htmlspecialchars($topic['icon'] ?? 'bi-journal') ?>"></i></div>
                                <div>
                                    <div class="fw-semibold text-dark-navy">{{ $topic['name'] }}</div>
                                    <small class="text-secondary-custom">{{ $topic['mcq_count'] }} MCQs &middot; <span class="sk-badge sk-badge-{{ $topic['difficulty'] }}">{{ ucfirst($topic['difficulty']) }}</span></small>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right text-muted"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                @include('components.empty-state', ['icon' => 'bi-list-ul', 'title' => 'No topics yet', 'message' => 'Topics for this subject will show up here once added.'])
                @endif
            </div>
            <div class="col-lg-4">
                <h2 class="sk-section-title">Difficulty</h2>
                <p class="sk-section-subtitle">MCQ distribution by difficulty</p>
                <?php
                $difficultyTotal = array_sum($difficulty);
                $difficultyPercent = function (int $count) use ($difficultyTotal): int {
                    return $difficultyTotal > 0 ? (int) round($count / $difficultyTotal * 100) : 0;
                };
                ?>
                @if($difficultyTotal > 0)
                <div class="sk-info-box">
                    <div class="mb-3"><div class="d-flex justify-content-between mb-1"><span class="sk-badge sk-badge-easy"><i class="bi bi-circle-fill"></i> Easy</span><strong><?= $difficultyPercent($difficulty['easy']) ?>%</strong></div><div class="sk-progress"><div class="sk-progress-bar bg-success" style="width:<?= $difficultyPercent($difficulty['easy']) ?>%"></div></div><small class="text-secondary-custom">{{ $difficulty['easy'] }} MCQs</small></div>
                    <div class="mb-3"><div class="d-flex justify-content-between mb-1"><span class="sk-badge sk-badge-medium"><i class="bi bi-circle-fill"></i> Medium</span><strong><?= $difficultyPercent($difficulty['medium']) ?>%</strong></div><div class="sk-progress"><div class="sk-progress-bar" style="width:<?= $difficultyPercent($difficulty['medium']) ?>%;background-color:var(--sk-warning);"></div></div><small class="text-secondary-custom">{{ $difficulty['medium'] }} MCQs</small></div>
                    <div><div class="d-flex justify-content-between mb-1"><span class="sk-badge sk-badge-hard"><i class="bi bi-circle-fill"></i> Hard</span><strong><?= $difficultyPercent($difficulty['hard']) ?>%</strong></div><div class="sk-progress"><div class="sk-progress-bar bg-error" style="width:<?= $difficultyPercent($difficulty['hard']) ?>%"></div></div><small class="text-secondary-custom">{{ $difficulty['hard'] }} MCQs</small></div>
                </div>
                @if(count($relatedTestTypes) > 0)
                <div class="mt-4">
                    <a href="{{ route('test-types.subject', [$relatedTestTypes[0]['slug'], $subject['slug']]) }}" class="btn btn-sk-gold w-100 btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
                </div>
                @endif
                @else
                <p class="text-secondary-custom small">No MCQs yet for this subject.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <h2 class="sk-section-title">Related Test Types</h2>
        <p class="sk-section-subtitle">{{ $subject['name'] }} is included in these exams</p>
        @if(count($relatedTestTypes) > 0)
        <div class="row g-4">
            @foreach($relatedTestTypes as $testType)
            <div class="col-sm-6 col-lg-4">
                <a href="{{ route('test-types.subject', [$testType['slug'], $subject['slug']]) }}" class="sk-card text-decoration-none">
                    <div class="sk-card-icon bg-icon-navy"><i class="bi <?= htmlspecialchars($testType['icon'] ?? 'bi-diagram-3') ?>"></i></div>
                    <h3 class="sk-card-title">{{ $testType['name'] }} {{ $subject['name'] }}</h3>
                    <p class="sk-card-text">{{ $subject['name'] }} MCQs for {{ $testType['name'] }} preparation.</p>
                    <div class="sk-card-meta"><span><i class="bi bi-collection"></i> {{ $mcqCount }} MCQs</span></div>
                    <span class="btn btn-sk-outline btn-sm-sk w-100">Practice <i class="bi bi-arrow-right ms-1"></i></span>
                </a>
            </div>
            @endforeach
        </div>
        @else
        @include('components.empty-state', ['icon' => 'bi-diagram-3', 'title' => 'Not linked to any test type yet', 'message' => 'This subject isn\'t part of a test type yet.'])
        @endif
    </div>
</section>
@endsection
