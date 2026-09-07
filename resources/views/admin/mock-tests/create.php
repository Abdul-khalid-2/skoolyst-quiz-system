@extends('layouts.dashboard')

@section('page_title', 'Create Mock Test')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Create Mock Test</h2>
        <p class="text-secondary-custom mb-0">Set up a new full-length timed mock test.</p>
    </div>
    <a href="{{ route('dashboard.mock-tests') }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-arrow-left me-1"></i>Back to Mock Tests</a>
</div>

<div class="sk-info-box">
    <form method="POST" action="{{ route('dashboard.mock-tests.create') }}" novalidate>
        <?= csrf_field() ?>
        @include('admin.mock-tests._form', ['errors' => $errors, 'testTypes' => $testTypes, 'mcqs' => $mcqs, 'selectedMcqIds' => $selectedMcqIds, 'mockTest' => []])
        <button type="submit" class="btn btn-sk-gold mt-3"><i class="bi bi-check-circle me-1"></i>Save Mock Test</button>
    </form>
</div>
@endsection
