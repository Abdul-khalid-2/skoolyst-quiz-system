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

                @include('components.mcq-practice', [
                    'mcqs' => $mcqs,
                    'mcqOptions' => $mcqOptions,
                    'backUrl' => route('topics.show', $topic['slug']),
                    'backLabel' => 'Back to Topic',
                    'resultUrl' => route('topics.result', $topic['slug']),
                    'submitUrl' => is_authenticated() ? route('practice.submit', $topic['slug']) : null,
                ])
            </div>
        </div>
    </div>
</section>
@endsection
