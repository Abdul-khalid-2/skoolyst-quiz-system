@extends('layouts.dashboard')

@section('page_title', 'Topics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Topics</h2>
        <p class="text-secondary-custom mb-0">Manage topics within each subject.</p>
    </div>
    <button class="sk-dash-quick-btn"><i class="bi bi-list-stars text-cyan"></i> Add Topic</button>
</div>

@if(count($topics) > 0)
<div class="sk-dash-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Subject</th>
                <th>Difficulty</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topics as $topic)
            <tr>
                <td class="fw-semibold">{{ $topic['name'] }}</td>
                <td>{{ $topic['subject_name'] }}</td>
                <td><span class="sk-badge sk-badge-{{ $topic['difficulty'] }}">{{ ucfirst($topic['difficulty']) }}</span></td>
                <td>{{ format_date($topic['created_at']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
@include('components.empty-state', ['icon' => 'bi-list-ul', 'title' => 'No topics yet', 'message' => 'Add a subject first, then break it down into topics.'])
@endif
@endsection
