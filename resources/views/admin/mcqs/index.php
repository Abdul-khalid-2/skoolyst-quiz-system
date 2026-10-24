@extends('layouts.dashboard')

@section('page_title', 'MCQs')

@section('content')
<?php
$listUrl   = route('dashboard.mcqs');
$returnUrl = safe_next_url($_SERVER['REQUEST_URI'] ?? null) ?? '';
$total     = (int) $pagination['total'];
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="mb-0">MCQs</h2>
        <p class="text-secondary-custom mb-0">Manage the multiple choice question bank.</p>
    </div>
    <a href="{{ route('dashboard.mcqs.create') }}" class="sk-dash-quick-btn text-decoration-none"><i class="bi bi-plus-circle text-navy"></i> Add MCQ</a>
</div>

<form method="GET" action="{{ $listUrl }}" id="mcqFilterForm" class="sk-info-box mb-3">
    <div class="row g-2 align-items-end">
        <div class="col-12 col-lg-4">
            <label for="f_q" class="sk-auth-label">Search</label>
            <input type="search" class="form-control" id="f_q" name="q" maxlength="100" value="{{ $filters['q'] }}" placeholder="Question text or MCQ ID...">
        </div>
        <div class="col-6 col-lg-2">
            <label for="f_subject" class="sk-auth-label">Subject</label>
            <select class="form-select" id="f_subject" name="subject_id">
                <option value="">All subjects</option>
                @foreach($subjects as $subject)
                <option value="{{ $subject['id'] }}" <?= (int) $filters['subject_id'] === (int) $subject['id'] ? 'selected' : '' ?>>{{ $subject['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-lg-2">
            <label for="f_topic" class="sk-auth-label">Topic</label>
            <select class="form-select" id="f_topic" name="topic_id">
                <option value="">All topics</option>
                <option value="none" <?= $filters['topic_id'] === 'none' ? 'selected' : '' ?>>No topic</option>
                @foreach($topicsBySubject as $subjectName => $subjectTopics)
                @foreach($subjectTopics as $topic)
                <option value="{{ $topic['id'] }}" data-subject-id="{{ $topic['subject_id'] }}" <?= (int) $filters['topic_id'] === (int) $topic['id'] ? 'selected' : '' ?>>{{ $topic['name'] }} ({{ $subjectName }})</option>
                @endforeach
                @endforeach
            </select>
        </div>
        <div class="col-6 col-lg-2">
            <label for="f_difficulty" class="sk-auth-label">Difficulty</label>
            <select class="form-select" id="f_difficulty" name="difficulty">
                <option value="">Any</option>
                @foreach(['easy', 'medium', 'hard'] as $level)
                <option value="{{ $level }}" <?= $filters['difficulty'] === $level ? 'selected' : '' ?>>{{ ucfirst($level) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-lg-2">
            <label for="f_per_page" class="sk-auth-label">Show</label>
            <select class="form-select" id="f_per_page" name="per_page">
                @foreach($perPageOptions as $option)
                <option value="{{ $option }}" <?= (int) $pagination['per_page'] === (int) $option ? 'selected' : '' ?>>{{ $option }} per page</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="d-flex gap-2 mt-3 flex-wrap">
        <button type="submit" class="btn btn-sk-gold btn-sm-sk"><i class="bi bi-search me-1"></i>Search</button>
        @if($hasFilters)
        <a href="{{ $listUrl }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-x-circle me-1"></i>Clear filters</a>
        @endif
    </div>
</form>

@if($total > 0)
<p class="text-secondary-custom small mb-2">
    Showing <strong>{{ $pagination['from'] }}&ndash;{{ $pagination['to'] }}</strong> of <strong>{{ $total }}</strong> MCQs<?= $hasFilters ? ' (filtered)' : '' ?>
    &middot; Page {{ $pagination['page'] }} of {{ $pagination['pages'] }}
</p>
<div class="sk-dash-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
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
            <?php $editUrl = route('dashboard.mcqs.edit', $mcq['id']) . ($returnUrl !== '' ? '?return=' . rawurlencode($returnUrl) : ''); ?>
            <tr>
                <td class="text-secondary-custom">{{ $mcq['id'] }}</td>
                <td>{{ mb_strimwidth($mcq['question_text'], 0, 90, '...') }}</td>
                <td>{{ $mcq['subject_name'] }}</td>
                <td>{{ $mcq['topic_name'] ?? '—' }}</td>
                <td><span class="sk-badge sk-badge-{{ $mcq['difficulty'] }}">{{ ucfirst($mcq['difficulty']) }}</span></td>
                <td>{{ format_date($mcq['created_at']) }}</td>
                <td class="text-end text-nowrap">
                    <a href="{{ $editUrl }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('dashboard.mcqs.delete', $mcq['id']) }}" class="d-inline" onsubmit="return confirm('Delete this MCQ? This cannot be undone.');">
                        <?= csrf_field() ?>
                        <input type="hidden" name="return" value="{{ $returnUrl }}">
                        <button type="submit" class="btn btn-sk-outline btn-sm-sk text-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('components.pagination', ['pagination' => $pagination, 'baseUrl' => $listUrl, 'query' => $query])
@elseif($hasFilters)
@include('components.empty-state', ['icon' => 'bi-search', 'title' => 'No MCQs match these filters', 'message' => 'Try a different search word, or clear the filters to see every question.'])
<div class="text-center mt-3"><a href="{{ $listUrl }}" class="btn btn-sk-outline btn-sm-sk">Clear filters</a></div>
@else
@include('components.empty-state', ['icon' => 'bi-collection', 'title' => 'No MCQs yet', 'message' => 'Questions you add to the bank will show up here.'])
@endif

<script>
(function () {
    var form = document.getElementById('mcqFilterForm');
    var subject = document.getElementById('f_subject');
    var topic = document.getElementById('f_topic');
    if (!form || !subject || !topic) return;

    var topicOptions = Array.prototype.slice.call(topic.querySelectorAll('option[data-subject-id]'));

    // Only offer topics that belong to the chosen subject.
    function syncTopics() {
        var subjectId = subject.value;
        var stillValid = !topic.value || topic.value === 'none';
        topicOptions.forEach(function (option) {
            var matches = !subjectId || option.getAttribute('data-subject-id') === subjectId;
            option.hidden = !matches;
            option.disabled = !matches;
            if (matches && option.selected) stillValid = true;
        });
        if (!stillValid) topic.value = '';
    }

    subject.addEventListener('change', function () { topic.value = ''; syncTopics(); form.submit(); });
    topic.addEventListener('change', form.submit.bind(form));
    document.getElementById('f_difficulty').addEventListener('change', form.submit.bind(form));
    document.getElementById('f_per_page').addEventListener('change', form.submit.bind(form));
    syncTopics();
})();
</script>
@endsection
