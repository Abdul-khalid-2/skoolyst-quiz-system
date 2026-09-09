@extends('layouts.app')

@section('title', $term !== '' ? 'Search results for "' . $term . '"' : 'Search')

@section('content')
<section class="sk-page-header">
    <div class="container">
        <h1><i class="bi bi-search me-2"></i>Search MCQs</h1>
        @if($term !== '')
        <p>{{ $totalCount }} result<?= $totalCount === 1 ? '' : 's' ?> for "{{ $term }}"</p>
        @else
        <p>Search across subjects, topics, and thousands of MCQs.</p>
        @endif

        <form method="GET" action="{{ route('search') }}" class="mt-3" style="max-width:640px;">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-secondary-custom"></i></span>
                <input type="text" name="q" value="{{ $term }}" class="form-control border-start-0 ps-0" placeholder="Search for MCQs, e.g. 'photosynthesis', 'calculus'..." autocomplete="off" />
                <button class="btn btn-sk-navy px-4" type="submit">Search</button>
            </div>
        </form>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        @if($term === '')
        @include('components.empty-state', ['icon' => 'bi-search', 'title' => 'Start typing to search', 'message' => 'Enter a keyword above to find subjects, topics, and MCQs.'])
        @elseif($totalCount === 0)
        @include('components.empty-state', ['icon' => 'bi-search', 'title' => 'No results found', 'message' => 'Try a different keyword or check your spelling.'])
        @else
            @if(count($results['subjects']) > 0)
            <h3 class="mb-3"><i class="bi bi-journal me-2"></i>Subjects</h3>
            <div class="sk-card-grid mb-4">
                @foreach($results['subjects'] as $subject)
                @include('components.subject-card', [
                    'name' => $subject['name'],
                    'icon' => $subject['icon'] ?? 'bi-journal',
                    'icon_bg' => $subject['icon_bg'] ?? 'bg-icon-navy',
                    'description' => $subject['description'] ?? '',
                    'topics' => \Skoolyst\Models\Subject::topicCount($subject['id']),
                    'mcqs' => \Skoolyst\Models\Subject::mcqCount($subject['id']),
                    'slug' => $subject['slug'],
                ])
                @endforeach
            </div>
            @endif

            @if(count($results['topics']) > 0)
            <h3 class="mb-3"><i class="bi bi-journal-text me-2"></i>Topics</h3>
            <div class="sk-info-box mb-4">
                @foreach($results['topics'] as $topic)
                <a href="{{ route('topics.show', $topic['slug']) }}" class="sk-activity-item text-decoration-none">
                    <div class="sk-activity-icon bg-icon-cyan"><i class="bi <?= htmlspecialchars($topic['icon'] ?? 'bi-journal-text') ?>"></i></div>
                    <div>
                        <div class="sk-activity-text">{{ $topic['name'] }}</div>
                        <span class="sk-badge sk-badge-light mt-1">{{ $topic['subject_name'] }}</span>
                        <span class="sk-badge sk-badge-{{ $topic['difficulty'] }} mt-1">{{ ucfirst($topic['difficulty']) }}</span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif

            @if(count($results['mcqs']) > 0)
            <h3 class="mb-3"><i class="bi bi-question-circle me-2"></i>MCQs</h3>
            <div class="sk-info-box">
                @foreach($results['mcqs'] as $mcq)
                <a href="{{ $mcq['topic_slug'] ? route('practice.show', $mcq['topic_slug']) : route('subjects.show', $mcq['subject_slug']) }}" class="sk-activity-item text-decoration-none">
                    <div class="sk-activity-icon bg-icon-navy"><i class="bi bi-question-circle"></i></div>
                    <div>
                        <div class="sk-activity-text">{{ $mcq['question_text'] }}</div>
                        <span class="sk-badge sk-badge-light mt-1">{{ $mcq['subject_name'] }}<?= $mcq['topic_name'] ? ' · ' . htmlspecialchars($mcq['topic_name']) : '' ?></span>
                        <span class="sk-badge sk-badge-{{ $mcq['difficulty'] }} mt-1">{{ ucfirst($mcq['difficulty']) }}</span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        @endif
    </div>
</section>
@endsection
