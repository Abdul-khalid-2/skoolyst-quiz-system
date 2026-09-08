@extends('layouts.app')

@section('title', 'Test Types')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Test Types', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1>Test Types</h1>
        <p>Choose your exam type and start practicing with targeted MCQs</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-6">
                <input type="text" id="sk-listing-search" class="form-control" placeholder="Search test types..." />
            </div>
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
            ])
            @endforeach
        </div>
    </div>
</section>
@endsection