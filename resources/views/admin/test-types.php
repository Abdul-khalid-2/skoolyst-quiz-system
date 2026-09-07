@extends('layouts.dashboard')

@section('page_title', 'Test Types')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Test Types</h2>
        <p class="text-secondary-custom mb-0">Manage exam categories like MDCAT, ECAT, and School Exams.</p>
    </div>
    <button class="sk-dash-quick-btn"><i class="bi bi-diagram-3 text-navy"></i> Add Test Type</button>
</div>

@if(count($testTypes) > 0)
<div class="sk-dash-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testTypes as $testType)
            <tr>
                <td class="fw-semibold">{{ $testType['name'] }}</td>
                <td><code>{{ $testType['slug'] }}</code></td>
                <td class="text-secondary-custom">{{ mb_strimwidth($testType['description'] ?? '', 0, 60, '...') }}</td>
                <td>{{ format_date($testType['created_at']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
@include('components.empty-state', ['icon' => 'bi-diagram-3', 'title' => 'No test types yet', 'message' => 'Test types you add will show up here.'])
@endif
@endsection
