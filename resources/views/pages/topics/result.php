@extends('layouts.app')

@section('title', 'Topic Test Result - ' . $topic['name'])

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [
    ['label' => 'Subjects', 'url' => route('subjects.index')],
    ['label' => $topic['subject_name'], 'url' => route('subjects.show', $topic['subject_slug'])],
    ['label' => $topic['name'], 'url' => route('topics.show', $topic['slug'])],
    ['label' => 'Result', 'url' => '#'],
]])

<section class="sk-page-header">
    <div class="container">
        <h1><i class="bi bi-clipboard2-check me-2"></i>Topic Test Result</h1>
        <p>{{ $topic['name'] }} — Practice Session Results</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        @include('components.empty-state', [
            'icon' => 'bi-clipboard2-data',
            'title' => 'No practice attempts recorded yet',
            'message' => 'Results will appear here once practice sessions are tracked for ' . $topic['name'] . '.',
        ])
        <div class="text-center">
            <a href="{{ route('practice.show', $topic['slug']) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Practice This Topic</a>
        </div>
    </div>
</section>
@endsection
