@extends('layouts.dashboard')

@section('page_title', 'Topics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Topics</h2>
        <p class="text-secondary-custom mb-0">Manage topics within each subject.</p>
    </div>
    <a href="{{ route('dashboard.topics.create') }}" class="sk-dash-quick-btn text-decoration-none"><i class="bi bi-list-stars text-cyan"></i> Add Topic</a>
</div>

@if(isset($success))
<div class="alert alert-success py-2 small">{{ $success }}</div>
@endif

@if(count($topics) > 0)
<div class="sk-dash-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Subject</th>
                <th>Difficulty</th>
                <th>Created</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topics as $topic)
            <tr>
                <td class="fw-semibold">{{ $topic['name'] }}</td>
                <td>{{ $topic['subject_name'] }}</td>
                <td><span class="sk-badge sk-badge-{{ $topic['difficulty'] }}">{{ ucfirst($topic['difficulty']) }}</span></td>
                <td>{{ format_date($topic['created_at']) }}</td>
                <td class="text-end">
                    <a href="{{ route('dashboard.topics.edit', $topic['id']) }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('dashboard.topics.delete', $topic['id']) }}" class="d-inline" onsubmit="return confirm('Delete this topic? Any MCQs assigned to it will become uncategorized (not deleted).');">
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
@include('components.empty-state', ['icon' => 'bi-list-ul', 'title' => 'No topics yet', 'message' => 'Add a subject first, then break it down into topics.'])
@endif
@endsection
