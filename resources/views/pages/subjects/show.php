@extends('layouts.app')

@section('title', 'Biology - Subject Detail')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Subjects', 'url' => route('subjects.index')], ['label' => 'Biology', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="sk-badge sk-badge-success mb-2"><i class="bi bi-tree"></i> Science</div>
                <h1>Biology</h1>
                <p>Explore the science of life. Practice MCQs on cell biology, genetics, human physiology, ecology, and more. Detailed explanations help you understand each concept thoroughly.</p>
                <div class="d-flex gap-2 flex-wrap mt-3">
                    <a href="{{ route('test-types.subject', ['mdcat', $slug]) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
                    <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-outline-light btn-lg"><i class="bi bi-clipboard-check me-2"></i>Mock Tests</a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi bi-tree-fill" style="font-size:6rem;color:rgba(22,163,74,0.3);"></i>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="2500">0</div><div class="sk-stat-label">Total MCQs</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="12">0</div><div class="sk-stat-label">Topics</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="3">0</div><div class="sk-stat-label">Test Types</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="5">0</div><div class="sk-stat-label">Mock Tests</div></div></div>
        </div>
    </div>
</section>

<section class="sk-section bg-soft">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <h2 class="sk-section-title">Topics</h2>
                <p class="sk-section-subtitle">Practice MCQs by specific topic</p>
                <div class="row g-3">
                    <div class="col-md-6"><a href="{{ route('topics.show', 'cell-biology') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-dna"></i></div><div><div class="fw-semibold text-dark-navy">Cell Biology</div><small class="text-secondary-custom">320 MCQs &middot; <span class="sk-badge sk-badge-easy">Easy</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'genetics') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-gender-male"></i></div><div><div class="fw-semibold text-dark-navy">Genetics</div><small class="text-secondary-custom">280 MCQs &middot; <span class="sk-badge sk-badge-medium">Medium</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'human-physiology') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-clipboard2-pulse"></i></div><div><div class="fw-semibold text-dark-navy">Human Physiology</div><small class="text-secondary-custom">250 MCQs &middot; <span class="sk-badge sk-badge-medium">Medium</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'digestive-system') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-lungs"></i></div><div><div class="fw-semibold text-dark-navy">Digestive System</div><small class="text-secondary-custom">200 MCQs &middot; <span class="sk-badge sk-badge-hard">Hard</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'circulatory-system') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-heart"></i></div><div><div class="fw-semibold text-dark-navy">Circulatory System</div><small class="text-secondary-custom">190 MCQs &middot; <span class="sk-badge sk-badge-easy">Easy</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'ecology') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-globe2"></i></div><div><div class="fw-semibold text-dark-navy">Ecology</div><small class="text-secondary-custom">170 MCQs &middot; <span class="sk-badge sk-badge-medium">Medium</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'plant-biology') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-flower1"></i></div><div><div class="fw-semibold text-dark-navy">Plant Biology</div><small class="text-secondary-custom">160 MCQs &middot; <span class="sk-badge sk-badge-easy">Easy</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'microbiology') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-bug"></i></div><div><div class="fw-semibold text-dark-navy">Microbiology</div><small class="text-secondary-custom">140 MCQs &middot; <span class="sk-badge sk-badge-hard">Hard</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                </div>
            </div>
            <div class="col-lg-4">
                <h2 class="sk-section-title">Difficulty</h2>
                <p class="sk-section-subtitle">MCQ distribution by difficulty</p>
                <div class="sk-info-box">
                    <div class="mb-3"><div class="d-flex justify-content-between mb-1"><span class="sk-badge sk-badge-easy"><i class="bi bi-circle-fill"></i> Easy</span><strong>40%</strong></div><div class="sk-progress"><div class="sk-progress-bar bg-success" style="width:40%"></div></div><small class="text-secondary-custom">1,000 MCQs</small></div>
                    <div class="mb-3"><div class="d-flex justify-content-between mb-1"><span class="sk-badge sk-badge-medium"><i class="bi bi-circle-fill"></i> Medium</span><strong>35%</strong></div><div class="sk-progress"><div class="sk-progress-bar" style="width:35%;background-color:var(--sk-warning);"></div></div><small class="text-secondary-custom">875 MCQs</small></div>
                    <div><div class="d-flex justify-content-between mb-1"><span class="sk-badge sk-badge-hard"><i class="bi bi-circle-fill"></i> Hard</span><strong>25%</strong></div><div class="sk-progress"><div class="sk-progress-bar bg-error" style="width:25%"></div></div><small class="text-secondary-custom">625 MCQs</small></div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('test-types.subject', ['mdcat', $slug]) }}" class="btn btn-sk-gold w-100 btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <h2 class="sk-section-title">Related Test Types</h2>
        <p class="sk-section-subtitle">Biology is included in these exams</p>
        <div class="row g-4">
            <div class="col-sm-6 col-lg-4">
                <a href="{{ route('test-types.subject', ['mdcat', $slug]) }}" class="sk-card text-decoration-none">
                    <div class="sk-card-icon bg-icon-navy"><i class="bi bi-heart-pulse"></i></div>
                    <h3 class="sk-card-title">MDCAT Biology</h3>
                    <p class="sk-card-text">Biology MCQs specifically for MDCAT preparation.</p>
                    <div class="sk-card-meta"><span><i class="bi bi-collection"></i> 1,200 MCQs</span></div>
                    <span class="btn btn-sk-outline btn-sm-sk w-100">Practice <i class="bi bi-arrow-right ms-1"></i></span>
                </a>
            </div>
            <div class="col-sm-6 col-lg-4">
                <a href="{{ route('test-types.subject', ['school', $slug]) }}" class="sk-card text-decoration-none">
                    <div class="sk-card-icon bg-icon-gold"><i class="bi bi-backpack"></i></div>
                    <h3 class="sk-card-title">School Exams — Biology</h3>
                    <p class="sk-card-text">Biology MCQs for school-level and board exams.</p>
                    <div class="sk-card-meta"><span><i class="bi bi-collection"></i> 800 MCQs</span></div>
                    <span class="btn btn-sk-outline btn-sm-sk w-100">Practice <i class="bi bi-arrow-right ms-1"></i></span>
                </a>
            </div>
            <div class="col-sm-6 col-lg-4">
                <a href="{{ route('test-types.subject', ['general-knowledge', $slug]) }}" class="sk-card text-decoration-none">
                    <div class="sk-card-icon bg-icon-success"><i class="bi bi-globe-americas"></i></div>
                    <h3 class="sk-card-title">General Knowledge — Biology</h3>
                    <p class="sk-card-text">Everyday science and biology general knowledge MCQs.</p>
                    <div class="sk-card-meta"><span><i class="bi bi-collection"></i> 500 MCQs</span></div>
                    <span class="btn btn-sk-outline btn-sm-sk w-100">Practice <i class="bi bi-arrow-right ms-1"></i></span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
