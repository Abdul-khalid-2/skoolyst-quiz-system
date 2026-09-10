@extends('layouts.app')

@section('title', 'Topic Test Result - ' . $topic['name'])

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [
    ['label' => 'Subjects', 'url' => route('subjects.index')],
    ['label' => $topic['subject_name'], 'url' => route('subjects.show', $topic['subject_slug'])],
    ['label' => $topic['name'], 'url' => route('topics.show', $topic['slug'])],
    ['label' => 'Result', 'url' => '#'],
]])

<section class="sk-page-header">
    <div class="container">
        <h1><i class="bi bi-clipboard2-check me-2"></i>Topic Test Result</h1>
        <p>{{ $topic['name'] }} — Practice Session Results</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        @if($attempt === null)
        @if(!is_authenticated())
        @include('components.empty-state', [
            'icon' => 'bi-clipboard2-data',
            'title' => 'Log in to save your results',
            'message' => 'Create a free account or log in to have your practice results tracked here.',
        ])
        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="{{ route('login') }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Log In</a>
            <a href="{{ route('practice.show', $topic['slug']) }}" class="btn btn-sk-light btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Practice This Topic</a>
        </div>
        @else
        @include('components.empty-state', [
            'icon' => 'bi-clipboard2-data',
            'title' => 'No practice attempts recorded yet',
            'message' => 'Results will appear here once you complete a practice session for ' . $topic['name'] . '.',
        ])
        <div class="text-center">
            <a href="{{ route('practice.show', $topic['slug']) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Practice This Topic</a>
        </div>
        @endif
        @else
        <?php
            $total = (int) $attempt['total_questions'];
            $correct = (int) $attempt['correct_count'];
            $scorePercent = (float) $attempt['score_percent'];
            $wrong = 0;
            $unanswered = 0;
            foreach ($answers as $answer) {
                if ((int) $answer['is_correct'] === 1) continue;
                if ($answer['selected_option_id'] === null) $unanswered++;
                else $wrong++;
            }
            $ringColor = $scorePercent >= 80 ? '#16A34A' : ($scorePercent >= 60 ? '#0EA5E9' : ($scorePercent >= 40 ? '#F59E0B' : '#DC2626'));
            $ringStyle = "background: conic-gradient({$ringColor} 0% {$scorePercent}%, #E2E8F0 {$scorePercent}% 100%);";
        ?>

        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="sk-card text-center">
                    <div class="sk-result-ring mx-auto mb-2" style="<?= htmlspecialchars($ringStyle, ENT_QUOTES, 'UTF-8') ?>">
                        <div class="sk-result-ring-content">
                            <div class="sk-result-percent">{{ round($scorePercent) }}%</div>
                            <div class="sk-result-label">Your Score</div>
                        </div>
                    </div>
                    <p class="text-secondary-custom mb-0">Completed {{ format_date($attempt['completed_at']) }}</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row g-3">
                    <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number">{{ $total }}</div><div class="sk-stat-label">Total</div></div></div>
                    <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number text-success">{{ $correct }}</div><div class="sk-stat-label">Correct</div></div></div>
                    <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number text-danger">{{ $wrong }}</div><div class="sk-stat-label">Wrong</div></div></div>
                    <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number">{{ $unanswered }}</div><div class="sk-stat-label">Unanswered</div></div></div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap mb-4">
            <a href="{{ route('practice.show', $topic['slug']) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-arrow-repeat me-2"></i>Practice Again</a>
            <a href="{{ route('topics.show', $topic['slug']) }}" class="btn btn-sk-light btn-lg"><i class="bi bi-arrow-left me-2"></i>Back to Topic</a>
        </div>

        <h5 class="mb-3">Question Review</h5>
        @foreach($answers as $index => $answer)
        <?php $opts = $optionsByMcq[$answer['mcq_id']] ?? []; ?>
        <div class="sk-card mb-3">
            <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                <span class="sk-badge sk-badge-navy">Q{{ $index + 1 }}</span>
                <span class="sk-badge sk-badge-{{ $answer['difficulty'] }}">{{ ucfirst($answer['difficulty']) }}</span>
            </div>
            <p class="fw-semibold mb-3">{{ $answer['question_text'] }}</p>
            @foreach($opts as $option)
            <?php
                $isSelected = (int) $option['id'] === (int) $answer['selected_option_id'];
                $isCorrectOption = (int) $option['is_correct'] === 1;
                $cls = 'sk-mcq-option disabled';
                $icon = '';
                if ($isCorrectOption) {
                    $cls .= ' correct';
                    $icon = '<i class="bi bi-check-circle-fill sk-mcq-option-icon text-success ms-2"></i>';
                } elseif ($isSelected) {
                    $cls .= ' incorrect';
                    $icon = '<i class="bi bi-x-circle-fill sk-mcq-option-icon text-danger ms-2"></i>';
                }
            ?>
            <div class="{{ $cls }}">
                <span class="sk-mcq-option-letter">{{ $option['label'] }}</span>
                <span class="sk-mcq-option-text">{{ $option['option_text'] }}</span>
                <?= $icon ?>
            </div>
            @endforeach
            @if($answer['selected_option_id'] === null)
            <small class="text-secondary-custom mt-2 d-block"><i class="bi bi-dash-circle"></i> You did not answer this question.</small>
            @endif
            @if($answer['explanation'])
            <p class="text-secondary-custom small mt-3 mb-0"><i class="bi bi-lightbulb me-1"></i>{{ $answer['explanation'] }}</p>
            @endif
        </div>
        @endforeach
        @endif
    </div>
</section>
@endsection
