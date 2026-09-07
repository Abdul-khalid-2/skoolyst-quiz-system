@extends('layouts.app')

@section('title', 'MDCAT - Test Type Detail')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Test Types', 'url' => route('test-types.index')], ['label' => 'MDCAT', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex gap-2 flex-wrap mb-2">
                    <span class="sk-badge sk-badge-gold"><i class="bi bi-heart-pulse"></i> Medical &amp; Dental</span>
                </div>
                <h1>MDCAT</h1>
                <p>Medical and Dental College Admission Test. Prepare with thousands of MCQs covering Biology, Chemistry, Physics, and English. Get detailed explanations and track your progress.</p>
                <div class="d-flex gap-2 flex-wrap mt-3">
                    <a href="{{ route('subjects.index') }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practicing</a>
                    <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-outline-light btn-lg"><i class="bi bi-clipboard-check me-2"></i>Mock Tests</a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi bi-heart-pulse-fill" style="font-size:6rem;color:rgba(245,166,35,0.3);"></i>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row g-3">
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="3500">0</div><div class="sk-stat-label">Total MCQs</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="4">0</div><div class="sk-stat-label">Subjects</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="32">0</div><div class="sk-stat-label">Topics</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="12">0</div><div class="sk-stat-label">Mock Tests</div></div></div>
        </div>
    </div>
</section>

<section class="sk-section bg-soft">
    <div class="container">
        <h2 class="sk-section-title">Related Subjects</h2>
        <p class="sk-section-subtitle">Subjects covered in MDCAT</p>
        <div class="row g-4">
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('test-types.subject', ['mdcat', 'biology']) }}" class="sk-card text-decoration-none">
                    <div class="sk-card-icon bg-icon-success"><i class="bi bi-tree"></i></div>
                    <h3 class="sk-card-title">Biology</h3>
                    <p class="sk-card-text">Cell biology, genetics, physiology, and ecology.</p>
                    <div class="sk-card-meta"><span><i class="bi bi-collection"></i> 1,200 MCQs</span></div>
                    <span class="btn btn-sk-outline btn-sm-sk w-100">Practice <i class="bi bi-arrow-right ms-1"></i></span>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('test-types.subject', ['mdcat', 'chemistry']) }}" class="sk-card text-decoration-none">
                    <div class="sk-card-icon bg-icon-info"><i class="bi bi-flask"></i></div>
                    <h3 class="sk-card-title">Chemistry</h3>
                    <p class="sk-card-text">Organic, inorganic, and physical chemistry.</p>
                    <div class="sk-card-meta"><span><i class="bi bi-collection"></i> 900 MCQs</span></div>
                    <span class="btn btn-sk-outline btn-sm-sk w-100">Practice <i class="bi bi-arrow-right ms-1"></i></span>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('test-types.subject', ['mdcat', 'physics']) }}" class="sk-card text-decoration-none">
                    <div class="sk-card-icon bg-icon-navy"><i class="bi bi-atom"></i></div>
                    <h3 class="sk-card-title">Physics</h3>
                    <p class="sk-card-text">Mechanics, electricity, optics, modern physics.</p>
                    <div class="sk-card-meta"><span><i class="bi bi-collection"></i> 800 MCQs</span></div>
                    <span class="btn btn-sk-outline btn-sm-sk w-100">Practice <i class="bi bi-arrow-right ms-1"></i></span>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a href="{{ route('test-types.subject', ['mdcat', 'english']) }}" class="sk-card text-decoration-none">
                    <div class="sk-card-icon bg-icon-cyan"><i class="bi bi-translate"></i></div>
                    <h3 class="sk-card-title">English</h3>
                    <p class="sk-card-text">Grammar, vocabulary, and comprehension.</p>
                    <div class="sk-card-meta"><span><i class="bi bi-collection"></i> 600 MCQs</span></div>
                    <span class="btn btn-sk-outline btn-sm-sk w-100">Practice <i class="bi bi-arrow-right ms-1"></i></span>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <h2 class="sk-section-title">Popular Topics</h2>
        <p class="sk-section-subtitle">Most practiced MDCAT topics</p>
        <div class="row g-3">
            <div class="col-md-6 col-lg-4"><a href="{{ route('topics.show', 'cell-biology') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-dna"></i></div><div><div class="fw-semibold text-dark-navy">Cell Biology</div><small class="text-secondary-custom">320 MCQs</small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
            <div class="col-md-6 col-lg-4"><a href="{{ route('topics.show', 'human-physiology') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-info mb-0"><i class="bi bi-clipboard2-pulse"></i></div><div><div class="fw-semibold text-dark-navy">Human Physiology</div><small class="text-secondary-custom">280 MCQs</small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
            <div class="col-md-6 col-lg-4"><a href="{{ route('topics.show', 'electricity') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-navy mb-0"><i class="bi bi-lightning-charge"></i></div><div><div class="fw-semibold text-dark-navy">Electricity</div><small class="text-secondary-custom">250 MCQs</small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
            <div class="col-md-6 col-lg-4"><a href="{{ route('topics.show', 'organic-chemistry') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-info mb-0"><i class="bi bi-droplet"></i></div><div><div class="fw-semibold text-dark-navy">Organic Chemistry</div><small class="text-secondary-custom">230 MCQs</small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
            <div class="col-md-6 col-lg-4"><a href="{{ route('topics.show', 'english-comprehension') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-cyan mb-0"><i class="bi bi-book"></i></div><div><div class="fw-semibold text-dark-navy">English Comprehension</div><small class="text-secondary-custom">200 MCQs</small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
            <div class="col-md-6 col-lg-4"><a href="{{ route('topics.show', 'genetics') }}" class="sk-list-item text-decoration-none"><div class="d-flex align-items-center gap-3"><div class="sk-card-icon bg-icon-success mb-0"><i class="bi bi-gender-male"></i></div><div><div class="fw-semibold text-dark-navy">Genetics</div><small class="text-secondary-custom">180 MCQs</small></div></div><i class="bi bi-chevron-right text-muted"></i></a></div>
        </div>
    </div>
</section>

<section class="sk-section bg-soft">
    <div class="container">
        <h2 class="sk-section-title">Available Practice Sections</h2>
        <p class="sk-section-subtitle">Choose how you want to practice</p>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="sk-card">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="sk-card-icon bg-icon-navy mb-0"><i class="bi bi-collection-play"></i></div>
                        <div><h4 class="mb-0">Topic-wise Practice</h4><small class="text-secondary-custom">Practice MCQs by specific topic</small></div>
                    </div>
                    <p class="sk-card-text mt-2">Select individual topics and practice MCQs one by one with instant feedback and explanations.</p>
                    <a href="{{ route('test-types.subject', ['mdcat', 'biology']) }}" class="btn btn-sk-navy btn-sm-sk w-100">Start Topic Practice</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="sk-card">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="sk-card-icon bg-icon-gold mb-0"><i class="bi bi-clipboard2-check"></i></div>
                        <div><h4 class="mb-0">Full Mock Tests</h4><small class="text-secondary-custom">Timed exam simulation</small></div>
                    </div>
                    <p class="sk-card-text mt-2">Take full-length MDCAT mock tests with a timer, question palette, and detailed results.</p>
                    <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-gold btn-sm-sk w-100">Browse Mock Tests</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sk-section bg-dark-navy text-white" style="padding:3rem 0;">
    <div class="container text-center">
        <h2 class="text-white mb-2">Ready to Ace MDCAT?</h2>
        <p class="mb-4" style="color:rgba(255,255,255,0.8);">Start practicing now and track your improvement.</p>
        <a href="{{ route('test-types.subject', ['mdcat', 'biology']) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practicing</a>
    </div>
</section>
@endsection
