@extends('layouts.dashboard')

@section('page_title', 'Add Topic')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Add Topic</h2>
        <p class="text-secondary-custom mb-0">Create a new topic within a subject.</p>
    </div>
    <a href="{{ route('dashboard.topics') }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-arrow-left me-1"></i>Back to Topics</a>
</div>

<div class="sk-info-box">
    <form method="POST" action="{{ route('dashboard.topics.create') }}" novalidate>
        <?= csrf_field() ?>
        @include('admin.topics._form', ['errors' => $errors, 'subjects' => $subjects, 'topic' => []])
        <button type="submit" class="btn btn-sk-gold mt-3"><i class="bi bi-check-circle me-1"></i>Save Topic</button>
    </form>
</div>
@endsection
