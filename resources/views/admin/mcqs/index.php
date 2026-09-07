@extends('layouts.dashboard')

@section('page_title', 'MCQs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">MCQs</h2>
        <p class="text-secondary-custom mb-0">Manage the multiple choice question bank.</p>
    </div>
    <a href="{{ route('dashboard.mcqs.create') }}" class="sk-dash-quick-btn text-decoration-none"><i class="bi bi-plus-circle text-navy"></i> Add MCQ</a>
</div>

@if(count($mcqs) > 0)
<div class="sk-dash-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Question</th>
                <th>Subject</th>
                <th>Topic</th>
                <th>Difficulty</th>
                <th>Created</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mcqs as $mcq)
            <tr>
                <td>{{ mb_strimwidth($mcq['question_text'], 0, 70, '...') }}</td>
                <td>{{ $mcq['subject_name'] }}</td>
                <td>{{ $mcq['topic_name'] ?? '—' }}</td>
                <td><span class="sk-badge sk-badge-{{ $mcq['difficulty'] }}">{{ ucfirst($mcq['difficulty']) }}</span></td>
                <td>{{ format_date($mcq['created_at']) }}</td>
                <td class="text-end">
                    <a href="{{ route('dashboard.mcqs.edit', $mcq['id']) }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('dashboard.mcqs.delete', $mcq['id']) }}" class="d-inline" onsubmit="return confirm('Delete this MCQ? This cannot be undone.');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sk-outline btn-sm-sk text-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
@include('components.empty-state', ['icon' => 'bi-collection', 'title' => 'No MCQs yet', 'message' => 'Questions you add to the bank will show up here.'])
@endif
@endsection
