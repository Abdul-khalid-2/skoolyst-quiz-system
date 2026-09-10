@extends('layouts.app')

@section('title', $mockTest['title'] . ' - Result')
@section('meta_description', 'Your performance report for ' . $mockTest['title'] . '.')

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [['label' => 'Mock Tests', 'url' => route('mock-tests.index')], ['label' => $mockTest['title'], 'url' => route('mock-tests.show', $mockTest['slug'])], ['label' => 'Result', 'url' => '#']]])

<section class="sk-page-header">
    <div class="container">
        <h1><i class="bi bi-clipboard2-check me-2"></i>Mock Test Result</h1>
        <p>{{ $mockTest['title'] }} — Your Performance Report</p>
    </div>
</section>

<section class="sk-section">
    <div class="container">
        @if($attempt === null)
        @include('components.empty-state', [
            'icon' => 'bi-clipboard2-data',
            'title' => 'No result to show',
            'message' => 'Take this mock test to see your performance report here.',
        ])
        <div class="text-center">
            <a href="{{ route('mock-tests.show', $mockTest['slug']) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-play-circle-fill me-2"></i>Go to Test Details</a>
        </div>
        @else
        <?php
            $total = (int) $attempt['total_questions'];
            $correct = (int) $attempt['correct_count'];
            $scorePercent = (float) $attempt['score_percent'];
            $passingScore = (int) $attempt['passing_score_percent'];
            $passed = $scorePercent >= $passingScore;
            $unanswered = 0;
            $wrong = 0;
            $subjectStats = [];
            foreach ($answers as $answer) {
                $subject = $answer['subject_name'];
                $subjectStats[$subject] ??= ['total' => 0, 'correct' => 0];
                $subjectStats[$subject]['total']++;
                if ((int) $answer['is_correct'] === 1) {
                    $subjectStats[$subject]['correct']++;
                } elseif ($answer['selected_option_id'] === null) {
                    $unanswered++;
                } else {
                    $wrong++;
                }
            }
            $timeTaken = (int) ($attempt['time_taken_seconds'] ?? 0);
            $timeTakenLabel = sprintf('%dm %02ds', intdiv($timeTaken, 60), $timeTaken % 60);
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
                    <span class="sk-badge {{ $passed ? 'sk-badge-easy' : 'sk-badge-hard' }} mb-2">{{ $passed ? 'Passed' : 'Not Passed' }}</span>
                    <p class="text-secondary-custom mb-0">Passing score: {{ $passingScore }}%</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row g-3">
                    <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number">{{ $total }}</div><div class="sk-stat-label">Total</div></div></div>
                    <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number text-success">{{ $correct }}</div><div class="sk-stat-label">Correct</div></div></div>
                    <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number text-danger">{{ $wrong }}</div><div class="sk-stat-label">Wrong</div></div></div>
                    <div class="col-6 col-md-3"><div class="sk-stat"><div class="sk-stat-number">{{ $unanswered }}</div><div class="sk-stat-label">Unanswered</div></div></div>
                </div>
                <div class="sk-info-box mt-3">
                    <div class="sk-info-row"><span class="sk-info-label">Time Taken</span><span class="sk-info-value">{{ $timeTakenLabel }}</span></div>
                    <div class="sk-info-row"><span class="sk-info-label">Completed</span><span class="sk-info-value">{{ format_date($attempt['completed_at']) }}</span></div>
                </div>
            </div>
        </div>

        @if(count($subjectStats) > 0)
        <div class="sk-card mb-4">
            <h5 class="mb-3"><i class="bi bi-bar-chart me-2"></i>Subject-wise Performance</h5>
            @foreach($subjectStats as $subjectName => $stat)
            <?php $pct = $stat['total'] > 0 ? round($stat['correct'] / $stat['total'] * 100) : 0; ?>
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span>{{ $subjectName }}</span>
                    <span class="text-secondary-custom">{{ $stat['correct'] }}/{{ $stat['total'] }} ({{ $pct }}%)</span>
                </div>
                <div class="sk-progress"><div class="sk-progress-bar" style="width: {{ $pct }}%"></div></div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="d-flex gap-2 flex-wrap mb-4">
            <a href="{{ route('mock-tests.take', $mockTest['slug']) }}" class="btn btn-sk-gold btn-lg"><i class="bi bi-arrow-repeat me-2"></i>Retake Test</a>
            <a href="{{ route('mock-tests.show', $mockTest['slug']) }}" class="btn btn-sk-light btn-lg"><i class="bi bi-arrow-left me-2"></i>Back to Test Details</a>
        </div>

        <h5 class="mb-3">Question Review</h5>
        @foreach($answers as $index => $answer)
        <?php $opts = $optionsByMcq[$answer['mcq_id']] ?? []; ?>
        <div class="sk-card mb-3">
            <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                <span class="sk-badge sk-badge-navy">Q{{ $index + 1 }}</span>
                <div class="d-flex gap-2">
                    @if((int) $answer['is_marked_for_review'] === 1)
                    <span class="sk-badge sk-badge-gold"><i class="bi bi-bookmark-fill"></i> Marked</span>
                    @endif
                    <span class="sk-badge sk-badge-light">{{ $answer['subject_name'] }}</span>
                </div>
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
