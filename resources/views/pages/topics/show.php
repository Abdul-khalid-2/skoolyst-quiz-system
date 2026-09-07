@extends('layouts.app')

@section('title', 'Cell Biology - Topic')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Subjects', 'url' => route('subjects.index')], ['label' => 'Biology', 'url' => route('subjects.show', 'biology')], ['label' => 'Cell Biology', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex gap-2 flex-wrap mb-2">
                    <span class="sk-badge sk-badge-success"><i class="bi bi-tree"></i> Biology</span>
                    <span class="sk-badge sk-badge-easy"><i class="bi bi-bar-chart"></i> Easy</span>
                </div>
                <h1>Cell Biology</h1>
                <p>Explore the fundamental unit of life. Practice MCQs on cell structure, organelles, cellular processes, and cell division. Each question comes with a detailed explanation.</p>
                <div class="d-flex gap-3 flex-wrap mt-3">
                    <div><i class="bi bi-collection text-cyan"></i> <strong>320</strong> MCQs</div>
                    <div><i class="bi bi-list-ul text-cyan"></i> <strong>8</strong> Sub-topics</div>
                    <div><i class="bi bi-bar-chart text-cyan"></i> <strong>Easy</strong> difficulty</div>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi bi-dna" style="font-size:6rem;color:rgba(22,163,74,0.3);"></i>
            </div>
        </div>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div id="sk-topic-mcq">
                    <div id="sk-topic-main"></div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-grid-3x3-gap me-1"></i>Question Palette</h6>
                    <div id="sk-palette" class="sk-palette-grid"></div>
                </div>
                <div class="sk-info-box mb-3">
                    <h6><i class="bi bi-info-circle me-1"></i>Topic Info</h6>
                    <div class="sk-info-row"><span class="sk-info-label">Subject</span><span class="sk-info-value">Biology</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Topic</span><span class="sk-info-value">Cell Biology</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Total MCQs</span><span class="sk-info-value">320</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Difficulty</span><span class="sk-info-value">Easy</span></div>
                </div>
                <div class="sk-info-box">
                    <h6><i class="bi bi-lightbulb me-1"></i>Topic Description</h6>
                    <p class="small text-secondary-custom mb-0">Cell biology is the study of cell structure and function, and it revolves around the concept that the cell is the fundamental unit of life. This topic covers cell organelles, cellular metabolism, cell division (mitosis and meiosis), and cell signaling.</p>
                </div>
                <a href="{{ route('practice.show', $slug) }}" class="btn btn-sk-gold w-100 mt-3"><i class="bi bi-play-circle-fill me-2"></i>Start Practice</a>
            </div>
        </div>
    </div>
</section>
@endsection
