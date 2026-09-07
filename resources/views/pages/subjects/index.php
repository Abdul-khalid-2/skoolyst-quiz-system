@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Subjects', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1>Subjects</h1>
        <p>Browse MCQs by subject area — from sciences to languages and general knowledge</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-6">
                <input type="text" id="sk-listing-search" class="form-control" placeholder="Search subjects..." />
            </div>
        </div>
        <div class="row g-4">
            @include('components.subject-card', ['name' => 'Biology', 'icon' => 'bi-tree', 'icon_bg' => 'bg-icon-success', 'description' => 'Cell biology, genetics, human physiology, ecology, and plant biology.', 'topics' => '12', 'mcqs' => '2,500', 'slug' => 'biology'])
            @include('components.subject-card', ['name' => 'Chemistry', 'icon' => 'bi-flask', 'icon_bg' => 'bg-icon-info', 'description' => 'Organic, inorganic, physical chemistry, periodic table, and chemical reactions.', 'topics' => '10', 'mcqs' => '2,200', 'slug' => 'chemistry'])
            @include('components.subject-card', ['name' => 'Physics', 'icon' => 'bi-atom', 'icon_bg' => 'bg-icon-navy', 'description' => 'Mechanics, electricity, magnetism, optics, thermodynamics, and modern physics.', 'topics' => '11', 'mcqs' => '2,000', 'slug' => 'physics'])
            @include('components.subject-card', ['name' => 'Mathematics', 'icon' => 'bi-calculator', 'icon_bg' => 'bg-icon-gold', 'description' => 'Algebra, calculus, geometry, trigonometry, and statistics.', 'topics' => '9', 'mcqs' => '1,800', 'slug' => 'mathematics'])
            @include('components.subject-card', ['name' => 'English', 'icon' => 'bi-translate', 'icon_bg' => 'bg-icon-cyan', 'description' => 'Grammar, vocabulary, reading comprehension, and sentence correction.', 'topics' => '8', 'mcqs' => '1,500', 'slug' => 'english'])
            @include('components.subject-card', ['name' => 'General Knowledge', 'icon' => 'bi-globe-americas', 'icon_bg' => 'bg-icon-success', 'description' => 'World history, geography, current affairs, and Pakistan studies.', 'topics' => '7', 'mcqs' => '1,200', 'slug' => 'general-knowledge'])
            @include('components.subject-card', ['name' => 'Computer Science', 'icon' => 'bi-keyboard', 'icon_bg' => 'bg-icon-navy', 'description' => 'Programming concepts, data structures, algorithms, and computer fundamentals.', 'topics' => '8', 'mcqs' => '1,000', 'slug' => 'computer-science'])
            @include('components.subject-card', ['name' => 'Urdu', 'icon' => 'bi-pen', 'icon_bg' => 'bg-icon-gold', 'description' => 'Urdu grammar, vocabulary, poetry, and literature comprehension.', 'topics' => '6', 'mcqs' => '800', 'slug' => 'urdu'])
            @include('components.subject-card', ['name' => 'Islamic Studies', 'icon' => 'bi-moon-stars', 'icon_bg' => 'bg-icon-success', 'description' => 'Quran, Hadith, Islamic history, and basic Islamic concepts.', 'topics' => '5', 'mcqs' => '700', 'slug' => 'islamic-studies'])
        </div>
    </div>
</section>
@endsection