@extends('layouts.app')

@section('title', $topic['name'] . ' - Topic')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [
    ['label' => 'Subjects', 'url' => route('subjects.index')],
    ['label' => $topic['subject_name'], 'url' => route('subjects.show', $topic['subject_slug'])],
    ['label' => $topic['name'], 'url' => '#'],
]])

<section class="sk-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex gap-2 flex-wrap mb-2">
                    <span class="sk-badge sk-badge-success"><i class="bi <?= htmlspecialchars($topic['icon'] ?? 'bi-journal') ?>"></i> {{ $topic['subject_name'] }}</span>
                    <span class="sk-badge sk-badge-{{ $topic['difficulty'] }}"><i class="bi bi-bar-chart"></i> {{ ucfirst($topic['difficulty']) }}</span>
                </div>
                <h1>{{ $topic['name'] }}</h1>
                <p>{{ $topic['description'] ?? ('Practice ' . $topic['name'] . ' MCQs as part of ' . $topic['subject_name'] . '.') }}</p>
                <div class="d-flex gap-3 flex-wrap mt-3">
                    <div><i class="bi bi-collection text-cyan"></i> <strong>{{ count($mcqs) }}</strong> MCQs</div>
                    <div><i class="bi bi-bar-chart text-cyan"></i> <strong>{{ ucfirst($topic['difficulty']) }}</strong> difficulty</div>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi <?= htmlspecialchars($topic['icon'] ?? 'bi-journal') ?>" style="font-size:6rem;color:rgba(22,163,74,0.3);"></i>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <h2 class="sk-section-title">Questions in this Topic</h2>
                @if(count($mcqs) > 0)
                <div class="sk-info-box">
                    @foreach($mcqs as $mcq)
                    <div class="sk-activity-item">
                        <div class="sk-activity-icon bg-icon-navy"><i class="bi bi-question-circle"></i></div>
                        <div>
                            <div class="sk-activity-text">{{ mb_strimwidth($mcq['question_text'], 0, 90, '...') }}</div>
                            <span class="sk-badge sk-badge-{{ $mcq['difficulty'] }} mt-1">{{ ucfirst($mcq['difficulty']) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                @include('components.empty-state', ['icon' => 'bi-collection', 'title' => 'No MCQs yet', 'message' => 'Questions for this topic will show up here once added.'])
                @endif
            </div>

            <div class="col-lg-4">
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-info-circle me-1"></i>Topic Info</h6>
                    <div class="sk-info-row"><span class="sk-info-label">Subject</span><span class="sk-info-value">{{ $topic['subject_name'] }}</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Topic</span><span class="sk-info-value">{{ $topic['name'] }}</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Total MCQs</span><span class="sk-info-value">{{ count($mcqs) }}</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Difficulty</span><span class="sk-info-value">{{ ucfirst($topic['difficulty']) }}</span></div>
                </div>
                @if($topic['description'])
                <div class="sk-info-box">
                    <h6><i class="bi bi-lightbulb me-1"></i>Topic Description</h6>
                    <p class="small text-secondary-custom mb-0">{{ $topic['description'] }}</p>
                </div>
                @endif
                @if(count($mcqs) > 0)
                <a href="{{ route('practice.show', $topic['slug']) }}" class="btn btn-sk-gold w-100 mt-3"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
