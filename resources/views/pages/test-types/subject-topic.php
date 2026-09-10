@extends('layouts.app')

@section('title', $topic['name'] . ' - ' . $subject['name'] . ' - ' . $testType['name'])

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [
    ['label' => 'Test Types', 'url' => route('test-types.index')],
    ['label' => $testType['name'], 'url' => route('test-types.show', $testType['slug'])],
    ['label' => $subject['name'], 'url' => route('test-types.subject', [$testType['slug'], $subject['slug']])],
    ['label' => $topic['name'], 'url' => '#'],
]])

<section class="sk-page-header">
    <div class="container">
        <div class="d-flex gap-2 flex-wrap mb-2">
            <span class="sk-badge sk-badge-gold"><i class="bi <?= htmlspecialchars($testType['icon'] ?? 'bi-diagram-3') ?>"></i> {{ $testType['name'] }}</span>
            <span class="sk-badge sk-badge-success"><i class="bi <?= htmlspecialchars($subject['icon'] ?? 'bi-journal') ?>"></i> {{ $subject['name'] }}</span>
            <span class="sk-badge sk-badge-{{ $topic['difficulty'] }}">{{ ucfirst($topic['difficulty']) }}</span>
        </div>
        <h1>{{ $topic['name'] }}</h1>
        <p>{{ $topic['description'] ?? ('Practice ' . $topic['name'] . ' MCQs as part of ' . $testType['name'] . ' ' . $subject['name'] . '.') }}</p>
        <div class="d-flex gap-2 flex-wrap mt-3">
            <a href="{{ route('practice.show', $topic['slug']) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
            <a href="{{ route('test-types.subject', [$testType['slug'], $subject['slug']]) }}" class="btn btn-sk-outline-light btn-lg"><i class="bi bi-arrow-left me-2"></i>Back to {{ $subject['name'] }}</a>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ count($mcqs) }}">0</div><div class="sk-stat-label">MCQs</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number">{{ ucfirst($topic['difficulty']) }}</div><div class="sk-stat-label">Difficulty</div></div></div>
        </div>

        @if(count($mcqs) > 0)
        <h3 class="mb-3">Questions</h3>
        @endif
        @include('components.mcq-practice', [
            'mcqs' => $mcqs,
            'mcqOptions' => $mcqOptions,
            'backUrl' => route('test-types.subject', [$testType['slug'], $subject['slug']]),
            'backLabel' => 'Back to ' . $subject['name'],
            'resultUrl' => route('topics.result', $topic['slug']),
            'submitUrl' => is_authenticated() ? route('practice.submit', $topic['slug']) : null,
        ])
    </div>
</section>
@endsection
