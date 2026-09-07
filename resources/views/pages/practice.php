@extends('layouts.app')

@section('title', 'Practice MCQs')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Subjects', 'url' => route('subjects.index')], ['label' => 'Biology', 'url' => route('subjects.show', 'biology')], ['label' => 'Cell Biology', 'url' => route('topics.show', $slug)], ['label' => 'Practice', 'url' => '#']]])

<section class="sk-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h2 class="sk-section-title mb-0">Practice MCQs</h2>
                        <p class="sk-section-subtitle mb-0">Cell Biology — Instant feedback with explanations</p>
                    </div>
                    <a href="{{ route('topics.result', $slug) }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-clipboard-data me-1"></i>View Results</a>
                </div>
                <div id="sk-practice-container"></div>
            </div>
        </div>
    </div>
</section>
@endsection
