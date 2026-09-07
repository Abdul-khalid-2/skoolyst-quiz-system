@extends('layouts.dashboard')

@section('page_title', 'MCQs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">MCQs</h2>
        <p class="text-secondary-custom mb-0">Manage the multiple choice question bank.</p>
    </div>
    <button class="sk-dash-quick-btn"><i class="bi bi-plus-circle text-navy"></i> Add MCQ</button>
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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
@include('components.empty-state', ['icon' => 'bi-collection', 'title' => 'No MCQs yet', 'message' => 'Questions you add to the bank will show up here.'])
@endif
@endsection
