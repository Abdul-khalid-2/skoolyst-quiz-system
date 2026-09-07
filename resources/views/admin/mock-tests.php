@extends('layouts.dashboard')

@section('page_title', 'Mock Tests')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Mock Tests</h2>
        <p class="text-secondary-custom mb-0">Manage full-length timed mock tests.</p>
    </div>
    <button class="sk-dash-quick-btn"><i class="bi bi-clipboard2-plus text-gold"></i> Create Mock Test</button>
</div>

@if(count($mockTests) > 0)
<div class="sk-dash-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Test Type</th>
                <th>Questions</th>
                <th>Duration</th>
                <th>Difficulty</th>
                <th>Featured</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mockTests as $mockTest)
            <tr>
                <td class="fw-semibold">{{ $mockTest['title'] }}</td>
                <td>{{ $mockTest['test_type_name'] }}</td>
                <td>{{ $mockTest['total_questions'] }}</td>
                <td>{{ $mockTest['duration_minutes'] }} min</td>
                <td><span class="sk-badge sk-badge-{{ $mockTest['difficulty'] }}">{{ ucfirst($mockTest['difficulty']) }}</span></td>
                <td><?= ((int) $mockTest['is_featured'] === 1) ? '<span class="sk-badge sk-badge-gold"><i class="bi bi-star-fill"></i> Featured</span>' : '<span class="text-secondary-custom">&mdash;</span>' ?></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
@include('components.empty-state', ['icon' => 'bi-clipboard2-check', 'title' => 'No mock tests yet', 'message' => 'Mock tests you create will show up here.'])
@endif
@endsection
