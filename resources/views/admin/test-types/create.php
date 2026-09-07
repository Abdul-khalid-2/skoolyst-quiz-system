@extends('layouts.dashboard')

@section('page_title', 'Add Test Type')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Add Test Type</h2>
        <p class="text-secondary-custom mb-0">Create a new exam category.</p>
    </div>
    <a href="{{ route('dashboard.test-types') }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-arrow-left me-1"></i>Back to Test Types</a>
</div>

<div class="sk-info-box">
    <form method="POST" action="{{ route('dashboard.test-types.create') }}" novalidate>
        <?= csrf_field() ?>
        @include('admin.test-types._form', ['errors' => $errors, 'testType' => []])
        <button type="submit" class="btn btn-sk-gold mt-3"><i class="bi bi-check-circle me-1"></i>Save Test Type</button>
    </form>
</div>
@endsection
