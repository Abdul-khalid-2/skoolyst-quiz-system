@extends('layouts.app')

@section('title', $testType['name'] . ' ' . $subject['name'] . ' - Subject + Test Type')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [
    ['label' => 'Test Types', 'url' => route('test-types.index')],
    ['label' => $testType['name'], 'url' => route('test-types.show', $testType['slug'])],
    ['label' => $subject['name'], 'url' => '#'],
]])

<section class="sk-page-header">
    <div class="container">
        <div class="d-flex gap-2 flex-wrap mb-2">
            <span class="sk-badge sk-badge-gold"><i class="bi <?= htmlspecialchars($testType['icon'] ?? 'bi-diagram-3') ?>"></i> {{ $testType['name'] }}</span>
            <span class="sk-badge sk-badge-success"><i class="bi <?= htmlspecialchars($subject['icon'] ?? 'bi-journal') ?>"></i> {{ $subject['name'] }}</span>
        </div>
        <h1>{{ $testType['name'] }} {{ $subject['name'] }}</h1>
        <p>Practice {{ $subject['name'] }} MCQs specifically curated for {{ $testType['name'] }} preparation. Filter by topic and difficulty to focus your study.</p>
        <div class="d-flex gap-2 flex-wrap mt-3">
            @if(count($topics) > 0)
            <a href="{{ route('test-types.subject.topic', [$testType['slug'], $subject['slug'], $topics[0]['slug']]) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
            <a href="{{ route('test-types.subject.topic', [$testType['slug'], $subject['slug'], $topics[0]['slug']]) }}" class="btn btn-sk-outline-light btn-lg"><i class="bi bi-journal-text me-2"></i>Browse Topics</a>
            @endif
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="sk-info-box mb-4">
                    <h6><i class="bi bi-funnel me-1"></i>Topic Filters</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="sk-filter-chip active" data-group="single">All Topics</span>
                        @foreach($topics as $topic)
                        <span class="sk-filter-chip" data-group="single">{{ $topic['name'] }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="sk-info-box mb-4">
                    <h6><i class="bi bi-bar-chart me-1"></i>Difficulty Filter</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="sk-filter-chip active" data-group="single">All Levels</span>
                        <span class="sk-filter-chip" data-group="single"><i class="bi bi-circle-fill text-success"></i> Easy</span>
                        <span class="sk-filter-chip" data-group="single"><i class="bi bi-circle-fill text-warning"></i> Medium</span>
                        <span class="sk-filter-chip" data-group="single"><i class="bi bi-circle-fill text-danger"></i> Hard</span>
                    </div>
                </div>

                <div class="sk-card bg-soft">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h4 class="mb-1">{{ $mcqCount }} MCQs Available</h4>
                            <p class="text-secondary-custom mb-0">Filtered by: All Topics &middot; All Difficulties</p>
                        </div>
                        @if(count($topics) > 0)
                        <a href="{{ route('test-types.subject.topic', [$testType['slug'], $subject['slug'], $topics[0]['slug']]) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
                        @endif
                        <a href="{{ route('subjects.result', $subject['slug']) }}" class="btn btn-sk-outline btn-lg"><i class="bi bi-clipboard2-data me-2"></i>View Sample Result</a>
                    </div>
                </div>

                <h3 class="mt-5 mb-3">Available Topics</h3>
                @if(count($topics) > 0)
                <div class="row g-3">
                    @foreach($topics as $topic)
                    <div class="col-md-6">
                        <a href="{{ route('test-types.subject.topic', [$testType['slug'], $subject['slug'], $topic['slug']]) }}" class="sk-list-item text-decoration-none">
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

                @if($sample !== null)
                <h3 class="mt-5 mb-3">Practice MCQs</h3>
                <div class="sk-card">
                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                        <div><span class="sk-badge sk-badge-navy">Sample</span> <span class="sk-badge sk-badge-{{ $sample['difficulty'] }}">{{ ucfirst($sample['difficulty']) }}</span></div>
                        <small class="text-secondary-custom">{{ $sample['topic_name'] ?? $subject['name'] }}</small>
                    </div>
                    <p class="fw-semibold mb-3">{{ $sample['question_text'] }}</p>
                    @foreach($sampleOptions as $option)
                    <div class="sk-mcq-option <?= (int) $option['is_correct'] === 1 ? 'selected' : '' ?>"><span class="sk-mcq-option-letter">{{ $option['label'] }}</span><span class="sk-mcq-option-text">{{ $option['option_text'] }}</span></div>
                    @endforeach
                    @if(count($topics) > 0)
                    <div class="mt-3">
                        <a href="{{ route('test-types.subject.topic', [$testType['slug'], $subject['slug'], $topics[0]['slug']]) }}" class="btn btn-sk-cyan btn-sm-sk">Start Full Practice <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-info-circle me-1"></i>Test Info</h6>
                    <div class="sk-info-row"><span class="sk-info-label">Test Type</span><span class="sk-info-value">{{ $testType['name'] }}</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Subject</span><span class="sk-info-value">{{ $subject['name'] }}</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Total MCQs</span><span class="sk-info-value">{{ $mcqCount }}</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Topics</span><span class="sk-info-value">{{ count($topics) }}</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Difficulty</span><span class="sk-info-value">Mixed</span></div>
                </div>
                <?php
                $difficultyTotal = array_sum($difficulty);
                $difficultyPercent = function (int $count) use ($difficultyTotal): int {
                    return $difficultyTotal > 0 ? (int) round($count / $difficultyTotal * 100) : 0;
                };
                ?>
                @if($difficultyTotal > 0)
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-bar-chart me-1"></i>Difficulty Distribution</h6>
                    <div class="mb-2"><small class="text-secondary-custom">Easy (<?= $difficultyPercent($difficulty['easy']) ?>%)</small><div class="sk-progress mt-1"><div class="sk-progress-bar bg-success" style="width:<?= $difficultyPercent($difficulty['easy']) ?>%"></div></div></div>
                    <div class="mb-2"><small class="text-secondary-custom">Medium (<?= $difficultyPercent($difficulty['medium']) ?>%)</small><div class="sk-progress mt-1"><div class="sk-progress-bar" style="width:<?= $difficultyPercent($difficulty['medium']) ?>%;background-color:var(--sk-warning);"></div></div></div>
                    <div><small class="text-secondary-custom">Hard (<?= $difficultyPercent($difficulty['hard']) ?>%)</small><div class="sk-progress mt-1"><div class="sk-progress-bar bg-error" style="width:<?= $difficultyPercent($difficulty['hard']) ?>%"></div></div></div>
                </div>
                @endif
                @if(count($topics) > 0)
                <a href="{{ route('test-types.subject.topic', [$testType['slug'], $subject['slug'], $topics[0]['slug']]) }}" class="btn btn-sk-gold w-100 btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
