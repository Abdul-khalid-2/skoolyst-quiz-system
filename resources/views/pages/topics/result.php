@extends('layouts.app')

@section('title', 'Topic Test Result')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Subjects', 'url' => route('subjects.index')], ['label' => 'Cell Biology', 'url' => route('topics.show', $slug)], ['label' => 'Result', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1><i class="bi bi-clipboard2-check me-2"></i>Topic Test Result</h1>
        <p>Cell Biology — Practice Session Results</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        <div id="sk-result-container" data-type="topic"></div>
    </div>
</section>
@endsection
