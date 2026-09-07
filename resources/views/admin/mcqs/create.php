@extends('layouts.dashboard')

@section('page_title', 'Add MCQ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Add MCQ</h2>
        <p class="text-secondary-custom mb-0">Create a new multiple choice question.</p>
    </div>
    <a href="{{ route('dashboard.mcqs') }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-arrow-left me-1"></i>Back to MCQs</a>
</div>

<div class="sk-info-box">
    <form method="POST" action="{{ route('dashboard.mcqs.create') }}" novalidate>
        <?= csrf_field() ?>
        @include('admin.mcqs._form', ['subjects' => $subjects, 'topicsBySubject' => $topicsBySubject, 'errors' => $errors, 'mcq' => [], 'options' => []])
        <button type="submit" class="btn btn-sk-gold mt-3"><i class="bi bi-check-circle me-1"></i>Save MCQ</button>
    </form>
</div>
@endsection
