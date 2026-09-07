@extends('layouts.app')

@section('title', 'MDCAT Biology - Subject + Test Type')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Test Types', 'url' => route('test-types.index')], ['label' => 'MDCAT', 'url' => route('test-types.show', $testType)], ['label' => 'Biology', 'url' => route('subjects.show', $subject)], ['label' => 'MDCAT Biology', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <div class="d-flex gap-2 flex-wrap mb-2">
            <span class="sk-badge sk-badge-gold"><i class="bi bi-heart-pulse"></i> MDCAT</span>
            <span class="sk-badge sk-badge-success"><i class="bi bi-tree"></i> Biology</span>
        </div>
        <h1>MDCAT Biology</h1>
        <p>Practice Biology MCQs specifically curated for MDCAT preparation. Filter by topic and difficulty to focus your study.</p>
        <div class="d-flex gap-2 flex-wrap mt-3">
            <a href="{{ route('practice.show', 'cell-biology') }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
            <a href="{{ route('topics.show', 'cell-biology') }}" class="btn btn-sk-outline-light btn-lg"><i class="bi bi-journal-text me-2"></i>Browse Topics</a>
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
                        <span class="sk-filter-chip" data-group="single">Cell Biology</span>
                        <span class="sk-filter-chip" data-group="single">Genetics</span>
                        <span class="sk-filter-chip" data-group="single">Human Physiology</span>
                        <span class="sk-filter-chip" data-group="single">Digestive System</span>
                        <span class="sk-filter-chip" data-group="single">Circulatory System</span>
                        <span class="sk-filter-chip" data-group="single">Ecology</span>
                        <span class="sk-filter-chip" data-group="single">Plant Biology</span>
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
                            <h4 class="mb-1">1,200 MCQs Available</h4>
                            <p class="text-secondary-custom mb-0">Filtered by: All Topics &middot; All Difficulties</p>
                        </div>
                        <a href="{{ route('practice.show', 'cell-biology') }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
                        <a href="{{ route('subjects.result', $subject) }}" class="btn btn-sk-outline btn-lg"><i class="bi bi-clipboard2-data me-2"></i>View Sample Result</a>
                    </div>
                </div>

                <h3 class="mt-5 mb-3">Available Topics</h3>
                <div class="row g-3">
                    <div class="col-md-6"><a href="{{ route('topics.show', 'cell-biology') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-dna"></i></div><div><div class="fw-semibold text-dark-navy">Cell Biology</div><small class="text-secondary-custom">320 MCQs &middot; <span class="sk-badge sk-badge-easy">Easy</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'genetics') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-gender-male"></i></div><div><div class="fw-semibold text-dark-navy">Genetics</div><small class="text-secondary-custom">280 MCQs &middot; <span class="sk-badge sk-badge-medium">Medium</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'human-physiology') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-clipboard2-pulse"></i></div><div><div class="fw-semibold text-dark-navy">Human Physiology</div><small class="text-secondary-custom">250 MCQs &middot; <span class="sk-badge sk-badge-medium">Medium</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                    <div class="col-md-6"><a href="{{ route('topics.show', 'digestive-system') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-lungs"></i></div><div><div class="fw-semibold text-dark-navy">Digestive System</div><small class="text-secondary-custom">200 MCQs &middot; <span class="sk-badge sk-badge-hard">Hard</span></small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
                </div>

                <h3 class="mt-5 mb-3">Practice MCQs</h3>
                <div class="sk-card">
                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                        <div><span class="sk-badge sk-badge-navy">Q1</span> <span class="sk-badge sk-badge-easy">Easy</span></div>
                        <small class="text-secondary-custom">Cell Biology</small>
                    </div>
                    <p class="fw-semibold mb-3">Which organelle is known as the powerhouse of the cell?</p>
                    <div class="sk-mcq-option"><span class="sk-mcq-option-letter">A</span><span class="sk-mcq-option-text">Nucleus</span></div>
                    <div class="sk-mcq-option selected"><span class="sk-mcq-option-letter">B</span><span class="sk-mcq-option-text">Mitochondria</span></div>
                    <div class="sk-mcq-option"><span class="sk-mcq-option-letter">C</span><span class="sk-mcq-option-text">Ribosome</span></div>
                    <div class="sk-mcq-option"><span class="sk-mcq-option-letter">D</span><span class="sk-mcq-option-text">Golgi apparatus</span></div>
                    <div class="mt-3">
                        <a href="{{ route('practice.show', 'cell-biology') }}" class="btn btn-sk-cyan btn-sm-sk">Start Full Practice <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-info-circle me-1"></i>Test Info</h6>
                    <div class="sk-info-row"><span class="sk-info-label">Test Type</span><span class="sk-info-value">MDCAT</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Subject</span><span class="sk-info-value">Biology</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Total MCQs</span><span class="sk-info-value">1,200</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Topics</span><span class="sk-info-value">8</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Difficulty</span><span class="sk-info-value">Mixed</span></div>
                </div>
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-bar-chart me-1"></i>Difficulty Distribution</h6>
                    <div class="mb-2"><small class="text-secondary-custom">Easy (40%)</small><div class="sk-progress mt-1"><div class="sk-progress-bar bg-success" style="width:40%"></div></div></div>
                    <div class="mb-2"><small class="text-secondary-custom">Medium (35%)</small><div class="sk-progress mt-1"><div class="sk-progress-bar" style="width:35%;background-color:var(--sk-warning);"></div></div></div>
                    <div><small class="text-secondary-custom">Hard (25%)</small><div class="sk-progress mt-1"><div class="sk-progress-bar bg-error" style="width:25%"></div></div></div>
                </div>
                <a href="{{ route('practice.show', 'cell-biology') }}" class="btn btn-sk-gold w-100 btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
            </div>
        </div>
    </div>
</section>
@endsection
