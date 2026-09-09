@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="sk-hero">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="sk-hero-tagline">Practice. Learn. Improve.</div>
                <h1>Master Your Exams with <span class="text-cyan">Skoolyst MCQs</span></h1>
                <p>Practice thousands of educational MCQs and prepare for your exams with Skoolyst. Interactive practice tests, detailed explanations, and real exam-like mock tests.</p>
                <div class="sk-hero-cta">
                    <a href="{{ route('test-types.index') }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practicing</a>
                    <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-outline-light btn-lg"><i class="bi bi-clipboard-check me-2"></i>Explore Mock Tests</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="text-center">
                    <i class="bi bi-mortarboard-fill" style="font-size:8rem;color:rgba(0,184,212,0.3);"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search MCQs Section -->
<section class="sk-section bg-soft">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="sk-section-title">Find MCQs to Practice</h2>
                <p class="sk-section-subtitle">Search across thousands of MCQs by subject, topic, or keyword</p>

                <form method="GET" action="{{ route('search') }}" class="sk-smart-search" data-search-api="{{ route('search.api') }}" data-search-url="{{ route('search') }}">
                    <div class="sk-smart-search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" name="q" class="sk-smart-search-input" placeholder="Search for MCQs, e.g. 'photosynthesis', 'calculus', 'MDCAT'..." autocomplete="off" />
                        <button type="button" class="sk-smart-search-clear" aria-label="Clear search">&times;</button>
                        <button type="submit" class="sk-smart-search-submit"><i class="bi bi-search d-md-none"></i><span class="d-none d-md-inline">Search</span></button>
                    </div>
                    <div class="sk-smart-search-dropdown"></div>
                </form>

                <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
                    <span class="text-secondary-custom me-2">Popular:</span>
                    @foreach($popularSubjects as $subject)
                    <a href="{{ route('subjects.show', $subject['slug']) }}" class="sk-filter-chip">{{ $subject['name'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="sk-section">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="sk-section-title">A Growing MCQ Library</h2>
            <p class="sk-section-subtitle">Thousands of questions across multiple subjects and test types</p>
        </div>
        <div class="row g-3">
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $stats['mcqs'] }}">0</div><div class="sk-stat-label">Total MCQs</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $stats['subjects'] }}">0</div><div class="sk-stat-label">Subjects</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $stats['topics'] }}">0</div><div class="sk-stat-label">Topics</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="{{ $stats['testTypes'] }}">0</div><div class="sk-stat-label">Test Types</div></div></div>
        </div>
    </div>
</section>

<!-- Test Types Section -->
<section class="sk-section bg-soft">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
            <div>
                <h2 class="sk-section-title mb-0">Test Types</h2>
                <p class="sk-section-subtitle mb-0">Choose your exam and start practicing</p>
            </div>
            <a href="{{ route('test-types.index') }}" class="btn btn-sk-outline btn-sm-sk">View All <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <?php $testTypeIconBg = ['sk-badge-navy' => 'bg-icon-navy', 'sk-badge-cyan' => 'bg-icon-cyan', 'sk-badge-gold' => 'bg-icon-gold', 'sk-badge-light' => 'bg-icon-info']; ?>
        <div class="sk-card-grid">
            @foreach($testTypes as $testType)
            @include('components.subject-card', [
                'name' => $testType['name'],
                'icon' => $testType['icon'] ?? 'bi-diagram-3',
                'icon_bg' => $testTypeIconBg[$testType['badge_class'] ?? ''] ?? 'bg-icon-navy',
                'description' => $testType['description'] ?? '',
                'topics' => $testType['subject_count'],
                'mcqs' => $testType['mcq_count'],
                'slug' => $testType['slug'],
                'route' => 'test-types.show',
            ])
            @endforeach
        </div>
    </div>
</section>

<!-- Subjects Section -->
<section class="sk-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
            <div>
                <h2 class="sk-section-title mb-0">Subjects</h2>
                <p class="sk-section-subtitle mb-0">Browse MCQs by subject area</p>
            </div>
            <a href="{{ route('subjects.index') }}" class="btn btn-sk-outline btn-sm-sk">View All <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        <div class="sk-card-grid">
            @foreach($subjects as $subject)
            @include('components.subject-card', [
                'name' => $subject['name'],
                'icon' => $subject['icon'] ?? 'bi-journal',
                'icon_bg' => $subject['icon_bg'] ?? 'bg-icon-navy',
                'description' => $subject['description'] ?? '',
                'topics' => $subject['topic_count'],
                'mcqs' => $subject['mcq_count'],
                'slug' => $subject['slug'],
            ])
            @endforeach
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="sk-section bg-soft">
    <div class="container">
        <h2 class="sk-section-title text-center">How It Works</h2>
        <p class="sk-section-subtitle text-center">Start practicing in three simple steps</p>
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="sk-card-icon bg-icon-navy mx-auto" style="width:64px;height:64px;font-size:1.8rem;"><i class="bi bi-1-circle"></i></div>
                    <h4 class="mt-3">Choose a Test Type</h4>
                    <p class="text-secondary-custom">Select from MDCAT, ECAT, School Exams, or browse by subject.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="sk-card-icon bg-icon-cyan mx-auto" style="width:64px;height:64px;font-size:1.8rem;"><i class="bi bi-2-circle"></i></div>
                    <h4 class="mt-3">Practice MCQs</h4>
                    <p class="text-secondary-custom">Answer questions, get instant feedback, and read detailed explanations.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="sk-card-icon bg-icon-gold mx-auto" style="width:64px;height:64px;font-size:1.8rem;"><i class="bi bi-3-circle"></i></div>
                    <h4 class="mt-3">Take Mock Tests</h4>
                    <p class="text-secondary-custom">Simulate real exams with timed mock tests and track your performance.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="sk-section bg-dark-navy text-white" style="padding:3.5rem 0;">
    <div class="container text-center">
        <h2 class="text-white mb-2">Ready to Start Your Exam Preparation?</h2>
        <p class="mb-4" style="color:rgba(255,255,255,0.8);font-size:1.1rem;">Join thousands of students who are already practicing with Skoolyst MCQs.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('test-types.index') }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practicing Now</a>
            <a href="{{ route('mock-tests.index') }}" class="btn btn-sk-outline-light btn-lg"><i class="bi bi-clipboard-check me-2"></i>Browse Mock Tests</a>
        </div>
    </div>
</section>
@endsection

@section('extra_js')
<script src="{{ asset('assets/js/smart-search.js') }}"></script>
@endsection