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
                    <a href="#" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
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
@endsection