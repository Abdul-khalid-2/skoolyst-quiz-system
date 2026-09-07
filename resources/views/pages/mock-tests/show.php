@extends('layouts.app')

@section('title', 'MDCAT Full Mock Test #1 - Mock Test Detail')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Mock Tests', 'url' => route('mock-tests.index')], ['label' => 'MDCAT Full Mock Test #1', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex gap-2 flex-wrap mb-2">
                    <span class="sk-badge sk-badge-gold"><i class="bi bi-star-fill"></i> Featured</span>
                    <span class="sk-badge sk-badge-navy">MDCAT</span>
                    <span class="sk-badge sk-badge-medium">Medium</span>
                </div>
                <h1>MDCAT Full Mock Test #1</h1>
                <p>Complete MDCAT simulation with all four subjects. Experience a real exam environment with timer, question palette, and detailed performance analysis after submission.</p>
                <a href="{{ route('mock-tests.take', $slug) }}" class="btn btn-sk-gold btn-lg mt-2"><i class="bi bi-play-circle-fill me-2"></i>Start Test</a>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi bi-clipboard2-check-fill" style="font-size:6rem;color:rgba(245,166,35,0.3);"></i>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="sk-info-box mb-4">
                    <h6><i class="bi bi-info-circle me-1"></i>Test Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="sk-info-row"><span class="sk-info-label">Test Title</span><span class="sk-info-value">MDCAT Full Mock Test #1</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Test Type</span><span class="sk-info-value">MDCAT</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Total Questions</span><span class="sk-info-value">200</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Duration</span><span class="sk-info-value">3 hours 30 minutes</span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="sk-info-row"><span class="sk-info-label">Difficulty</span><span class="sk-info-value">Medium</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Subjects</span><span class="sk-info-value">4 (Bio, Chem, Phys, Eng)</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Passing Score</span><span class="sk-info-value">50%</span></div>
                            <div class="sk-info-row"><span class="sk-info-label">Negative Marking</span><span class="sk-info-value">No</span></div>
                        </div>
                    </div>
                </div>

                <div class="sk-info-box mb-4">
                    <h6><i class="bi bi-exclamation-circle me-1"></i>Instructions</h6>
                    <ul class="mb-0">
                        <li class="mb-2">The test consists of <strong>200 multiple-choice questions</strong>.</li>
                        <li class="mb-2">Each question has <strong>4 options</strong> with only <strong>one correct answer</strong>.</li>
                        <li class="mb-2">You have <strong>3 hours and 30 minutes</strong> to complete the test.</li>
                        <li class="mb-2">Use the <strong>question palette</strong> to navigate between questions.</li>
                        <li class="mb-2">You can <strong>mark questions for review</strong> and return to them later.</li>
                        <li class="mb-2">The test will <strong>auto-submit</strong> when the timer reaches zero.</li>
                        <li class="mb-2">You will see a <strong>detailed performance report</strong> after submission.</li>
                    </ul>
                </div>

                <h3 class="mb-3">Question Preview</h3>
                <div class="sk-card mb-3">
                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                        <span class="sk-badge sk-badge-navy">Q1</span>
                        <span class="sk-badge sk-badge-light">Biology — Cell Biology</span>
                    </div>
                    <p class="fw-semibold mb-3">Which organelle is known as the powerhouse of the cell?</p>
                    <div class="sk-mcq-option"><span class="sk-mcq-option-letter">A</span><span>Nucleus</span></div>
                    <div class="sk-mcq-option"><span class="sk-mcq-option-letter">B</span><span>Mitochondria</span></div>
                    <div class="sk-mcq-option"><span class="sk-mcq-option-letter">C</span><span>Ribosome</span></div>
                    <div class="sk-mcq-option"><span class="sk-mcq-option-letter">D</span><span>Golgi apparatus</span></div>
                    <small class="text-secondary-custom mt-2 d-block"><i class="bi bi-info-circle"></i> This is a sample preview. The actual test has 200 questions.</small>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-clock me-1"></i>Time &amp; Questions</h6>
                    <div class="sk-info-row"><span class="sk-info-label">Duration</span><span class="sk-info-value">3h 30m</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Questions</span><span class="sk-info-value">200</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Avg/Q</span><span class="sk-info-value">~1 min</span></div>
                </div>
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-journals me-1"></i>Subjects Covered</h6>
                    <div class="sk-info-row"><span class="sk-info-label">Biology</span><span class="sk-info-value">80 Qs</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Chemistry</span><span class="sk-info-value">60 Qs</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Physics</span><span class="sk-info-value">40 Qs</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">English</span><span class="sk-info-value">20 Qs</span></div>
                </div>
                <a href="{{ route('mock-tests.take', $slug) }}" class="btn btn-sk-gold w-100 btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Test</a>
                <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-light w-100 mt-2"><i class="bi bi-arrow-left me-2"></i>Back to Mock Tests</a>
            </div>
        </div>
    </div>
</section>
@endsection
