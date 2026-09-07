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
                <div class="sk-info-box text-start">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-secondary-custom"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" placeholder="Search for MCQs, e.g. 'photosynthesis', 'calculus', 'MDCAT'..." />
                        <button class="btn btn-sk-navy px-4" type="button">Search</button>
                    </div>
                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <span class="text-secondary-custom me-2">Popular:</span>
                        <a href="{{ route('subjects.show', 'biology') }}" class="sk-filter-chip">Biology</a>
                        <a href="{{ route('subjects.show', 'chemistry') }}" class="sk-filter-chip">Chemistry</a>
                        <a href="{{ route('subjects.show', 'physics') }}" class="sk-filter-chip">Physics</a>
                        <a href="{{ route('subjects.show', 'mathematics') }}" class="sk-filter-chip">Mathematics</a>
                        <a href="{{ route('subjects.show', 'english') }}" class="sk-filter-chip">English</a>
                    </div>
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
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="15000">0</div><div class="sk-stat-label">Total MCQs</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="12">0</div><div class="sk-stat-label">Subjects</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="85">0</div><div class="sk-stat-label">Topics</div></div></div>
            <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number" data-counter="5">0</div><div class="sk-stat-label">Test Types</div></div></div>
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
        <div class="row g-4">
            @include('components.subject-card', ['name' => 'MDCAT', 'icon' => 'bi-heart-pulse', 'icon_bg' => 'bg-icon-navy', 'description' => 'Medical and Dental College Admission Test preparation with comprehensive MCQs.', 'topics' => '4', 'mcqs' => '3,500', 'slug' => 'mdcat'])
            @include('components.subject-card', ['name' => 'ECAT', 'icon' => 'bi-cpu', 'icon_bg' => 'bg-icon-cyan', 'description' => 'Engineering College Admission Test practice with physics, math, and chemistry MCQs.', 'topics' => '4', 'mcqs' => '2,800', 'slug' => 'ecat'])
            @include('components.subject-card', ['name' => 'School Exams', 'icon' => 'bi-backpack', 'icon_bg' => 'bg-icon-gold', 'description' => 'Practice MCQs for school-level exams across all major subjects and grade levels.', 'topics' => '8', 'mcqs' => '5,200', 'slug' => 'school'])
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
        <div class="row g-4">
            @include('components.subject-card', ['name' => 'Biology', 'icon' => 'bi-tree', 'icon_bg' => 'bg-icon-success', 'description' => 'Cell biology, genetics, human physiology, ecology, and more.', 'topics' => '12', 'mcqs' => '2,500', 'slug' => 'biology'])
            @include('components.subject-card', ['name' => 'Chemistry', 'icon' => 'bi-flask', 'icon_bg' => 'bg-icon-info', 'description' => 'Organic, inorganic, physical chemistry, periodic table, and reactions.', 'topics' => '10', 'mcqs' => '2,200', 'slug' => 'chemistry'])
            @include('components.subject-card', ['name' => 'Physics', 'icon' => 'bi-atom', 'icon_bg' => 'bg-icon-navy', 'description' => 'Mechanics, electricity, magnetism, optics, and modern physics.', 'topics' => '11', 'mcqs' => '2,000', 'slug' => 'physics'])
            @include('components.subject-card', ['name' => 'Mathematics', 'icon' => 'bi-calculator', 'icon_bg' => 'bg-icon-gold', 'description' => 'Algebra, calculus, geometry, trigonometry, and statistics.', 'topics' => '9', 'mcqs' => '1,800', 'slug' => 'mathematics'])
            @include('components.subject-card', ['name' => 'English', 'icon' => 'bi-translate', 'icon_bg' => 'bg-icon-cyan', 'description' => 'Grammar, vocabulary, comprehension, and sentence correction.', 'topics' => '8', 'mcqs' => '1,500', 'slug' => 'english'])
            @include('components.subject-card', ['name' => 'General Knowledge', 'icon' => 'bi-globe-americas', 'icon_bg' => 'bg-icon-success', 'description' => 'World history, geography, current affairs, and Pakistan studies.', 'topics' => '7', 'mcqs' => '1,200', 'slug' => 'general-knowledge'])
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