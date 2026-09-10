@extends('layouts.app')

@section('title', 'Mock Tests')
@section('meta_description', 'Take full-length timed mock tests that simulate real exam conditions for MDCAT, ECAT, school exams, and more.')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Mock Tests', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1>Mock Tests</h1>
        <p>Full-length timed practice tests that simulate real exam conditions</p>
    </div>
</section>

@if(count($mockTests) > 0)
<section class="sk-section pb-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <input type="text" id="sk-listing-search" class="form-control" placeholder="Search mock tests..." />
            </div>
        </div>
    </div>
</section>

@if($featured)
<section class="sk-section pt-3">
    <div class="container">
        <div class="sk-card" style="background: linear-gradient(135deg, var(--sk-dark-navy), var(--sk-navy)); color: white; border: none;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="sk-badge sk-badge-gold mb-2"><i class="bi bi-star-fill"></i> Featured</span>
                    <h2 class="text-white">{{ $featured['title'] }}</h2>
                    <p style="color: rgba(255,255,255,0.85);">{{ $featured['description'] ?? '' }}</p>
                    <div class="d-flex gap-4 flex-wrap mt-3">
                        <div><i class="bi bi-list-ol text-cyan"></i> <strong>{{ $featured['total_questions'] }}</strong> Questions</div>
                        <div><i class="bi bi-clock text-cyan"></i> <strong>{{ $featured['duration_minutes'] }}m</strong></div>
                        <div><i class="bi bi-bar-chart text-cyan"></i> <strong>{{ ucfirst($featured['difficulty']) }}</strong></div>
                        <div><i class="bi bi-journals text-cyan"></i> <strong>{{ $featured['test_type_name'] }}</strong></div>
                    </div>
                    <a href="{{ route('mock-tests.show', $featured['slug']) }}" class="btn btn-sk-gold btn-lg mt-3"><i class="bi bi-play-circle-fill me-2"></i>Start Test</a>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-center">
                    <i class="bi bi-clipboard2-check-fill" style="font-size:6rem;color:rgba(245,166,35,0.3);"></i>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="sk-section pt-0">
    <div class="container">
        <h2 class="sk-section-title">All Mock Tests</h2>
        <p class="sk-section-subtitle">Choose a test and start practicing under exam conditions</p>
        <div class="row g-4">
            @foreach($mockTests as $mockTest)
            <div class="col-md-6 col-lg-4" data-searchable="{{ $mockTest['title'] }} {{ $mockTest['test_type_name'] }}">
                <div class="sk-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="sk-badge sk-badge-navy">{{ $mockTest['test_type_name'] }}</span>
                        <span class="sk-badge sk-badge-{{ $mockTest['difficulty'] }}">{{ ucfirst($mockTest['difficulty']) }}</span>
                    </div>
                    <h3 class="sk-card-title">{{ $mockTest['title'] }}</h3>
                    <p class="sk-card-text">{{ $mockTest['description'] ?? '' }}</p>
                    <div class="sk-card-meta">
                        <span><i class="bi bi-list-ol"></i> {{ $mockTest['total_questions'] }} Qs</span>
                        <span><i class="bi bi-clock"></i> {{ $mockTest['duration_minutes'] }}m</span>
                    </div>
                    <a href="{{ route('mock-tests.show', $mockTest['slug']) }}" class="btn btn-sk-navy btn-sm-sk w-100">View Details</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="sk-section">
    <div class="container">
        @include('components.empty-state', [
            'icon' => 'bi-clipboard2-check',
            'title' => 'No mock tests yet',
            'message' => 'Mock tests will show up here once they are added.',
        ])
    </div>
</section>
@endif
@endsection
