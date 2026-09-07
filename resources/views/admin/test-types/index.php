@extends('layouts.dashboard')

@section('page_title', 'Test Types')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Test Types</h2>
        <p class="text-secondary-custom mb-0">Manage exam categories like MDCAT, ECAT, and School Exams.</p>
    </div>
    <a href="{{ route('dashboard.test-types.create') }}" class="sk-dash-quick-btn text-decoration-none"><i class="bi bi-diagram-3 text-navy"></i> Add Test Type</a>
</div>

@if(isset($error))
<div class="alert alert-danger py-2 small">{{ $error }}</div>
@endif
@if(isset($success))
<div class="alert alert-success py-2 small">{{ $success }}</div>
@endif

@if(count($testTypes) > 0)
<div class="sk-dash-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Created</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testTypes as $testType)
            <tr>
                <td>
                    <span class="sk-badge <?= htmlspecialchars($testType['badge_class'] ?? 'sk-badge-light') ?>"><i class="bi <?= htmlspecialchars($testType['icon'] ?? 'bi-diagram-3') ?>"></i> {{ $testType['name'] }}</span>
                </td>
                <td><code>{{ $testType['slug'] }}</code></td>
                <td class="text-secondary-custom">{{ mb_strimwidth($testType['description'] ?? '', 0, 60, '...') }}</td>
                <td>{{ format_date($testType['created_at']) }}</td>
                <td class="text-end">
                    <a href="{{ route('dashboard.test-types.edit', $testType['id']) }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('dashboard.test-types.delete', $testType['id']) }}" class="d-inline" onsubmit="return confirm('Delete this test type? Its mock tests must be removed first.');">
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
@include('components.empty-state', ['icon' => 'bi-diagram-3', 'title' => 'No test types yet', 'message' => 'Test types you add will show up here.'])
@endif
@endsection
