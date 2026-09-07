@extends('layouts.app')

@section('title', 'Mock Tests')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Mock Tests', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1>Mock Tests</h1>
        <p>Full-length timed practice tests that simulate real exam conditions</p>
    </div>
</section>

<section class="sk-section pb-2">
    <div class="container">
        <div class="row g-3 align-items-center">
            <div class="col-lg-5">
                <input type="text" id="sk-listing-search" class="form-control" placeholder="Search mock tests..." />
            </div>
            <div class="col-lg-7">
                <div class="d-flex gap-2 flex-wrap">
                    <span class="sk-filter-chip active" data-group="single">All</span>
                    <span class="sk-filter-chip" data-group="single">MDCAT</span>
                    <span class="sk-filter-chip" data-group="single">ECAT</span>
                    <span class="sk-filter-chip" data-group="single">School</span>
                    <span class="sk-filter-chip" data-group="single">English</span>
                    <span class="sk-filter-chip" data-group="single">General Knowledge</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sk-section pt-3">
    <div class="container">
        <div class="sk-card" style="background: linear-gradient(135deg, var(--sk-dark-navy), var(--sk-navy)); color: white; border: none;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="sk-badge sk-badge-gold mb-2"><i class="bi bi-star-fill"></i> Featured</span>
                    <h2 class="text-white">MDCAT Full Mock Test #1</h2>
                    <p style="color: rgba(255,255,255,0.85);">Complete MDCAT simulation with all four subjects. Real exam experience with timer, question palette, and detailed performance analysis.</p>
                    <div class="d-flex gap-4 flex-wrap mt-3">
                        <div><i class="bi bi-list-ol text-cyan"></i> <strong>200</strong> Questions</div>
                        <div><i class="bi bi-clock text-cyan"></i> <strong>3h 30m</strong></div>
                        <div><i class="bi bi-bar-chart text-cyan"></i> <strong>Medium</strong></div>
                        <div><i class="bi bi-journals text-cyan"></i> <strong>4</strong> Subjects</div>
                    </div>
                    <a href="#" class="btn btn-sk-gold btn-lg mt-3"><i class="bi bi-play-circle-fill me-2"></i>Start Test</a>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-center">
                    <i class="bi bi-clipboard2-check-fill" style="font-size:6rem;color:rgba(245,166,35,0.3);"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sk-section pt-0">
    <div class="container">
        <h2 class="sk-section-title">All Mock Tests</h2>
        <p class="sk-section-subtitle">Choose a test and start practicing under exam conditions</p>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="sk-card">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="sk-badge sk-badge-navy">MDCAT</span>
                        <span class="sk-badge sk-badge-medium">Medium</span>
                    </div>
                    <h3 class="sk-card-title">MDCAT Full Mock Test #1</h3>
                    <p class="sk-card-text">Complete MDCAT simulation covering Biology, Chemistry, Physics, and English.</p>
                    <div class="sk-card-meta">
                        <span><i class="bi bi-list-ol"></i> 200 Qs</span>
                        <span><i class="bi bi-clock"></i> 3h 30m</span>
                        <span><i class="bi bi-journals"></i> 4 Subjects</span>
                    </div>
                    <a href="#" class="btn btn-sk-navy btn-sm-sk w-100">View Details</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection