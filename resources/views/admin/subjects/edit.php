@extends('layouts.dashboard')

@section('page_title', 'Edit Subject')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Edit Subject</h2>
        <p class="text-secondary-custom mb-0">Update this subject.</p>
    </div>
    <a href="{{ route('dashboard.subjects') }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-arrow-left me-1"></i>Back to Subjects</a>
</div>

<div class="sk-info-box">
    <form method="POST" action="{{ route('dashboard.subjects.edit', $subject['id']) }}" novalidate>
        <?= csrf_field() ?>
        @include('admin.subjects._form', ['errors' => $errors, 'subject' => $subject])
        <button type="submit" class="btn btn-sk-gold mt-3"><i class="bi bi-check-circle me-1"></i>Update Subject</button>
    </form>
</div>
@endsection
