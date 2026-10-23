@extends('layouts.app')

<?php $metaDescription = 'Browse all subjects on Skoolyst MCQs: Biology, Chemistry, Physics, English, Urdu, Islamic Studies, General Knowledge and more. Practice MCQs with answers.'; ?>
@section('title', 'All Subjects - Practice MCQs by Subject')
@section('meta_description', $metaDescription)

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Subjects', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1>Subjects</h1>
        <p>Browse MCQs by subject area — from sciences to languages and general knowledge</p>
    </div>
</section>

@include('components.ad-slot', ['placement' => 'subject_top'])

<section class="sk-section">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-6">
                <input type="text" id="sk-listing-search" class="form-control" placeholder="Search subjects..." />
            </div>
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
@endsection