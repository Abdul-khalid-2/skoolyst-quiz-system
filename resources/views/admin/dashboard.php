@extends('layouts.dashboard')

@section('page_title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Welcome back, {{ auth_user()['name'] ?? 'Admin' }}!</h2>
        <p class="text-secondary-custom mb-0">Here's what's happening with your MCQ platform today.</p>
    </div>
    <small class="text-secondary-custom"><i class="bi bi-calendar3 me-1"></i> {{ date('F d, Y') }}</small>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        @include('components.stat-card', ['number' => $stats['mcqs'], 'label' => 'Total MCQs', 'icon' => 'bi-collection', 'icon_class' => 'bg-icon-navy'])
    </div>
    <div class="col-sm-6 col-lg-3">
        @include('components.stat-card', ['number' => $stats['subjects'], 'label' => 'Total Subjects', 'icon' => 'bi-journals', 'icon_class' => 'bg-icon-success'])
    </div>
    <div class="col-sm-6 col-lg-3">
        @include('components.stat-card', ['number' => $stats['topics'], 'label' => 'Total Topics', 'icon' => 'bi-list-ul', 'icon_class' => 'bg-icon-cyan'])
    </div>
    <div class="col-sm-6 col-lg-3">
        @include('components.stat-card', ['number' => $stats['mockTests'], 'label' => 'Total Mock Tests', 'icon' => 'bi-clipboard2-check', 'icon_class' => 'bg-icon-gold'])
    </div>
</div>

<!-- Quick Actions -->
<h5 class="mb-3"><i class="bi bi-lightning-charge text-gold me-1"></i>Quick Actions</h5>
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <a href="{{ route('dashboard.mcqs.create') }}" class="sk-dash-quick-btn text-decoration-none"><i class="bi bi-plus-circle text-navy"></i> Add MCQ</a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="{{ route('dashboard.subjects.create') }}" class="sk-dash-quick-btn text-decoration-none"><i class="bi bi-journal-plus text-success"></i> Add Subject</a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="{{ route('dashboard.topics.create') }}" class="sk-dash-quick-btn text-decoration-none"><i class="bi bi-list-stars text-cyan"></i> Add Topic</a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="{{ route('dashboard.mock-tests.create') }}" class="sk-dash-quick-btn text-decoration-none"><i class="bi bi-clipboard2-plus text-gold"></i> Create Mock Test</a>
    </div>
</div>

<div class="row g-4">
    <!-- Recent MCQs Table -->
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="bi bi-clock-history me-1"></i>Recent MCQs</h5>
            <a href="{{ route('dashboard.mcqs') }}" class="btn btn-sk-outline btn-sm-sk">View All</a>
        </div>
        @if(count($recentMcqs) > 0)
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
                    @foreach($recentMcqs as $mcq)
                    <tr>
                        <td>{{ mb_strimwidth($mcq['question_text'], 0, 60, '...') }}</td>
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
    </div>

    <!-- Recent Mock Tests -->
    <div class="col-lg-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="bi bi-clipboard2-check me-1"></i>Recent Mock Tests</h5>
            <a href="{{ route('dashboard.mock-tests') }}" class="btn btn-sk-outline btn-sm-sk">View All</a>
        </div>
        @if(count($recentMockTests) > 0)
        @foreach($recentMockTests as $mockTest)
        <div class="sk-card mb-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <div class="fw-semibold">{{ $mockTest['title'] }}</div>
                    <small class="text-secondary-custom">{{ $mockTest['test_type_name'] }} &middot; {{ $mockTest['total_questions'] }} Qs &middot; {{ $mockTest['duration_minutes'] }}min</small>
                </div>
                <span class="sk-badge sk-badge-{{ $mockTest['difficulty'] }}">{{ ucfirst($mockTest['difficulty']) }}</span>
            </div>
        </div>
        @endforeach
        @else
        @include('components.empty-state', ['icon' => 'bi-clipboard2-check', 'title' => 'No mock tests yet', 'message' => 'Mock tests you create will show up here.'])
        @endif
    </div>
</div>
@endsection
