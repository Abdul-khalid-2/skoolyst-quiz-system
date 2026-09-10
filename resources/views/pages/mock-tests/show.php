<?php $metaDescription = trim((string) ($mockTest['description'] ?? '')) !== '' ? $mockTest['description'] : $mockTest['title'] . ' — a timed mock test on Skoolyst MCQs.'; ?>
@extends('layouts.app')

@section('title', $mockTest['title'] . ' - Mock Test Detail')
@section('meta_description', $metaDescription)

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Mock Tests', 'url' => route('mock-tests.index')], ['label' => $mockTest['title'], 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex gap-2 flex-wrap mb-2">
                    @if((int) $mockTest['is_featured'] === 1)
                    <span class="sk-badge sk-badge-gold"><i class="bi bi-star-fill"></i> Featured</span>
                    @endif
                    <span class="sk-badge sk-badge-navy">{{ $mockTest['test_type_name'] }}</span>
                    <span class="sk-badge sk-badge-{{ $mockTest['difficulty'] }}">{{ ucfirst($mockTest['difficulty']) }}</span>
                </div>
                <h1>{{ $mockTest['title'] }}</h1>
                <p>{{ $mockTest['description'] ?? '' }}</p>
                @if($questionCount > 0)
                <a href="{{ route('mock-tests.take', $mockTest['slug']) }}" class="btn btn-sk-gold btn-lg mt-2"><i class="bi bi-play-circle-fill me-2"></i>Start Test</a>
                @endif
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi bi-clipboard2-check-fill" style="font-size:6rem;color:rgba(245,166,35,0.3);"></i>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        @if($questionCount === 0)
        @include('components.empty-state', [
            'icon' => 'bi-clipboard2-x',
            'title' => 'This mock test has no questions yet',
            'message' => 'Check back soon — questions are being added to this test.',
        ])
        @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="sk-info-box mb-4">
                    <h6><i class="bi bi-info-circle me-1"></i>Test Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="sk-info-row"><span class="sk-info-label">Test Title</span><span class="sk-info-value">{{ $mockTest['title'] }}</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Test Type</span><span class="sk-info-value">{{ $mockTest['test_type_name'] }}</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Total Questions</span><span class="sk-info-value">{{ $questionCount }}</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Duration</span><span class="sk-info-value">{{ $mockTest['duration_minutes'] }} minutes</span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="sk-info-row"><span class="sk-info-label">Difficulty</span><span class="sk-info-value">{{ ucfirst($mockTest['difficulty']) }}</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Subjects</span><span class="sk-info-value">{{ count($subjectBreakdown) }}</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Passing Score</span><span class="sk-info-value">{{ $mockTest['passing_score_percent'] }}%</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Negative Marking</span><span class="sk-info-value">{{ (int) $mockTest['negative_marking'] === 1 ? 'Yes' : 'No' }}</span></div>
                        </div>
                    </div>
                </div>

                <div class="sk-info-box mb-4">
                    <h6><i class="bi bi-exclamation-circle me-1"></i>Instructions</h6>
                    <ul class="mb-0">
                        <li class="mb-2">The test consists of <strong>{{ $questionCount }} multiple-choice questions</strong>.</li>
                        <li class="mb-2">Each question has <strong>4 options</strong> with only <strong>one correct answer</strong>.</li>
                        <li class="mb-2">You have <strong>{{ $mockTest['duration_minutes'] }} minutes</strong> to complete the test.</li>
                        <li class="mb-2">Use the <strong>question palette</strong> to navigate between questions.</li>
                        <li class="mb-2">You can <strong>mark questions for review</strong> and return to them later.</li>
                        <li class="mb-2">The test will <strong>auto-submit</strong> when the timer reaches zero.</li>
                        <li class="mb-2">You will see a <strong>detailed performance report</strong> after submission.</li>
                        @if((int) $mockTest['negative_marking'] === 1)
                        <li class="mb-2">Wrong answers carry <strong>negative marking</strong> (-0.25 per wrong answer).</li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-clock me-1"></i>Time &amp; Questions</h6>
                    <div class="sk-info-row"><span class="sk-info-label">Duration</span><span class="sk-info-value">{{ $mockTest['duration_minutes'] }}m</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Questions</span><span class="sk-info-value">{{ $questionCount }}</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Attempts so far</span><span class="sk-info-value">{{ $attemptCount }}</span></div>
                </div>
                @if(count($subjectBreakdown) > 0)
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-journals me-1"></i>Subjects Covered</h6>
                    @foreach($subjectBreakdown as $subject)
                    <div class="sk-info-row"><span class="sk-info-label">{{ $subject['name'] }}</span><span class="sk-info-value">{{ $subject['question_count'] }} Qs</span></div>
                    @endforeach
                </div>
                @endif
                <a href="{{ route('mock-tests.take', $mockTest['slug']) }}" class="btn btn-sk-gold w-100 btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Test</a>
                <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-light w-100 mt-2"><i class="bi bi-arrow-left me-2"></i>Back to Mock Tests</a>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
