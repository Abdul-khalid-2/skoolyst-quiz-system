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
        <div class="row g-4">
            @include('components.subject-card', ['name' => 'MDCAT', 'icon' => 'bi-heart-pulse', 'icon_bg' => 'bg-icon-navy', 'description' => 'Medical and Dental College Admission Test. Comprehensive MCQs covering Biology, Chemistry, Physics, and English.', 'topics' => '4', 'mcqs' => '3,500', 'slug' => 'mdcat'])
            @include('components.subject-card', ['name' => 'ECAT', 'icon' => 'bi-cpu', 'icon_bg' => 'bg-icon-cyan', 'description' => 'Engineering College Admission Test. Practice Physics, Mathematics, Chemistry, and English MCQs.', 'topics' => '4', 'mcqs' => '2,800', 'slug' => 'ecat'])
            @include('components.subject-card', ['name' => 'School Exams', 'icon' => 'bi-backpack', 'icon_bg' => 'bg-icon-gold', 'description' => 'MCQs for school-level exams across all major subjects and grade levels. Perfect for board exam preparation.', 'topics' => '8', 'mcqs' => '5,200', 'slug' => 'school'])
            @include('components.subject-card', ['name' => 'English', 'icon' => 'bi-translate', 'icon_bg' => 'bg-icon-info', 'description' => 'English language proficiency MCQs covering grammar, vocabulary, comprehension, and sentence correction.', 'topics' => '4', 'mcqs' => '1,500', 'slug' => 'english'])
            @include('components.subject-card', ['name' => 'General Knowledge', 'icon' => 'bi-globe-americas', 'icon_bg' => 'bg-icon-success', 'description' => 'World history, geography, current affairs, Pakistan studies, and everyday science MCQs.', 'topics' => '5', 'mcqs' => '1,200', 'slug' => 'general-knowledge'])
        </div>
    </div>
</section>
@endsection