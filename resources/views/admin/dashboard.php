@extends('layouts.dashboard')

@section('page_title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">Welcome back, Admin!</h2>
        <p class="text-secondary-custom mb-0">Here's what's happening with your MCQ platform today.</p>
    </div>
    <small class="text-secondary-custom"><i class="bi bi-calendar3 me-1"></i> {{ date('F d, Y') }}</small>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        @include('components.stat-card', ['number' => '15000', 'label' => 'Total MCQs', 'icon' => 'bi-collection', 'icon_class' => 'bg-icon-navy'])
    </div>
    <div class="col-sm-6 col-lg-3">
        @include('components.stat-card', ['number' => '12', 'label' => 'Total Subjects', 'icon' => 'bi-journals', 'icon_class' => 'bg-icon-success'])
    </div>
    <div class="col-sm-6 col-lg-3">
        @include('components.stat-card', ['number' => '85', 'label' => 'Total Topics', 'icon' => 'bi-list-ul', 'icon_class' => 'bg-icon-cyan'])
    </div>
    <div class="col-sm-6 col-lg-3">
        @include('components.stat-card', ['number' => '24', 'label' => 'Total Mock Tests', 'icon' => 'bi-clipboard2-check', 'icon_class' => 'bg-icon-gold'])
    </div>
</div>

<!-- Quick Actions -->
<h5 class="mb-3"><i class="bi bi-lightning-charge text-gold me-1"></i>Quick Actions</h5>
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <button class="sk-dash-quick-btn"><i class="bi bi-plus-circle text-navy"></i> Add MCQ</button>
    </div>
    <div class="col-6 col-lg-3">
        <button class="sk-dash-quick-btn"><i class="bi bi-journal-plus text-success"></i> Add Subject</button>
    </div>
    <div class="col-6 col-lg-3">
        <button class="sk-dash-quick-btn"><i class="bi bi-list-stars text-cyan"></i> Add Topic</button>
    </div>
    <div class="col-6 col-lg-3">
        <button class="sk-dash-quick-btn"><i class="bi bi-clipboard2-plus text-gold"></i> Create Mock Test</button>
    </div>
</div>

<div class="row g-4">
    <!-- Recent MCQs Table -->
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="bi bi-clock-history me-1"></i>Recent MCQs</h5>
            <a href="#" class="btn btn-sk-outline btn-sm-sk">View All</a>
        </div>
        <div class="sk-dash-table">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Subject</th>
                        <th>Topic</th>
                        <th>Difficulty</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Which organelle is the powerhouse of the cell?</td>
                        <td>Biology</td>
                        <td>Cell Biology</td>
                        <td><span class="sk-badge sk-badge-easy">Easy</span></td>
                        <td><span class="sk-badge sk-badge-easy"><i class="bi bi-check-circle"></i> Published</span></td>
                        <td>2h ago</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Activity Feed -->
    <div class="col-lg-4">
        <h5 class="mb-3"><i class="bi bi-activity me-1"></i>Recent Activity</h5>
        <div class="sk-info-box">
            <div class="sk-activity-item">
                <div class="sk-activity-icon bg-icon-success"><i class="bi bi-plus-circle"></i></div>
                <div>
                    <div class="sk-activity-text">New MCQ added to <strong>Cell Biology</strong></div>
                    <div class="sk-activity-time">2 hours ago</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection