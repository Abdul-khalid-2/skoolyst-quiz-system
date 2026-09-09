@extends('layouts.app')

@section('title', 'Practice MCQs - ' . $topic['name'])

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [
    ['label' => 'Subjects', 'url' => route('subjects.index')],
    ['label' => $topic['subject_name'], 'url' => route('subjects.show', $topic['subject_slug'])],
    ['label' => $topic['name'], 'url' => route('topics.show', $topic['slug'])],
    ['label' => 'Practice', 'url' => '#'],
]])

<section class="sk-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h2 class="sk-section-title mb-0">Practice MCQs</h2>
                        <p class="sk-section-subtitle mb-0">{{ $topic['name'] }} — Instant feedback with explanations</p>
                    </div>
                    <a href="{{ route('topics.result', $topic['slug']) }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-clipboard-data me-1"></i>View Results</a>
                </div>

                @if(count($mcqs) > 0)
                @foreach($mcqs as $mcq)
                <div class="sk-card mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                        <span class="sk-badge sk-badge-navy">Q<?= $loop->iteration ?></span>
                        <span class="sk-badge sk-badge-{{ $mcq['difficulty'] }}">{{ ucfirst($mcq['difficulty']) }}</span>
                    </div>
                    <p class="fw-semibold mb-3">{{ $mcq['question_text'] }}</p>
                    @foreach($mcqOptions[$mcq['id']] as $option)
                    <div class="sk-mcq-option <?= (int) $option['is_correct'] === 1 ? 'selected' : '' ?>"><span class="sk-mcq-option-letter">{{ $option['label'] }}</span><span class="sk-mcq-option-text">{{ $option['option_text'] }}</span></div>
                    @endforeach
                    @if($mcq['explanation'])
                    <p class="text-secondary-custom small mt-2 mb-0"><i class="bi bi-lightbulb me-1"></i>{{ $mcq['explanation'] }}</p>
                    @endif
                </div>
                @endforeach
                @else
                @include('components.empty-state', ['icon' => 'bi-collection', 'title' => 'No MCQs yet', 'message' => 'Questions for this topic will show up here once added.'])
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
