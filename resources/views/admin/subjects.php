@extends('layouts.dashboard')

@section('page_title', 'Subjects')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Subjects</h2>
        <p class="text-secondary-custom mb-0">Manage the subjects MCQs are organized under.</p>
    </div>
    <button class="sk-dash-quick-btn"><i class="bi bi-plus-circle text-navy"></i> Add Subject</button>
</div>

@if(count($subjects) > 0)
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
            @foreach($subjects as $subject)
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="sk-card-icon <?= htmlspecialchars($subject['icon_bg'] ?? 'bg-icon-navy') ?>" style="width:32px;height:32px;font-size:0.95rem;"><i class="bi <?= htmlspecialchars($subject['icon'] ?? 'bi-journal') ?>"></i></div>
                        <span class="fw-semibold">{{ $subject['name'] }}</span>
                    </div>
                </td>
                <td><code>{{ $subject['slug'] }}</code></td>
                <td class="text-secondary-custom">{{ mb_strimwidth($subject['description'] ?? '', 0, 60, '...') }}</td>
                <td>{{ format_date($subject['created_at']) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
@include('components.empty-state', ['icon' => 'bi-journals', 'title' => 'No subjects yet', 'message' => 'Subjects you add will show up here.'])
@endif
@endsection
