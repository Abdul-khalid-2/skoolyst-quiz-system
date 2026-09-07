@extends('layouts.app')

@section('title', 'Subject Test Result')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Subjects', 'url' => route('subjects.index')], ['label' => 'Biology', 'url' => route('subjects.show', $slug)], ['label' => 'Subject Test Result', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1><i class="bi bi-clipboard2-data me-2"></i>Subject Test Result</h1>
        <p>Biology — MDCAT Subject Assessment Results</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div id="sk-result-container" data-type="subject"></div>
    </div>
</section>
@endsection
