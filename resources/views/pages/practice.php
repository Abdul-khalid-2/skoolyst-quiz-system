@extends('layouts.app')

@section('title', 'Practice MCQs - ' . $topic['name'])

@section('schema')
<?php if (!empty($mcqs)): ?>
<script type="application/ld+json">
<?php
$questionSchemas = [];
foreach ($mcqs as $mcq) {
    $opts        = $mcqOptions[$mcq['id']] ?? [];
    $correctOpts = array_values(array_filter($opts, fn($o) => (int) $o['is_correct'] === 1));
    $wrongOpts   = array_values(array_filter($opts, fn($o) => (int) $o['is_correct'] === 0));

    $q = [
        '@type'            => 'Question',
        'name'             => $mcq['question_text'],
        'educationalLevel' => ucfirst($mcq['difficulty']),
    ];

    if (!empty($correctOpts)) {
        $acceptedAnswer = [
            '@type' => 'Answer',
            'text'  => $correctOpts[0]['label'] . '. ' . $correctOpts[0]['option_text'],
        ];
        if (!empty($mcq['explanation'])) {
            $acceptedAnswer['comment'] = $mcq['explanation'];
        }
        $q['acceptedAnswer'] = $acceptedAnswer;
    }

    if (!empty($wrongOpts)) {
        $q['suggestedAnswer'] = array_map(fn($o) => [
            '@type' => 'Answer',
            'text'  => $o['label'] . '. ' . $o['option_text'],
        ], $wrongOpts);
    }

    $questionSchemas[] = $q;
}

$practiceSchema = [
    '@context'          => 'https://schema.org',
    '@type'             => 'Quiz',
    'name'              => 'Practice ' . $topic['name'] . ' MCQs',
    'description'       => 'Practice ' . $topic['name'] . ' MCQs with instant feedback and detailed explanations. Part of ' . $topic['subject_name'] . '.',
    'url'               => htmlspecialchars(canonical_url(), ENT_QUOTES, 'UTF-8'),
    'educationalLevel'  => ucfirst($topic['difficulty']),
    'numberOfQuestions' => count($mcqs),
    'about'             => [
        '@type' => 'Thing',
        'name'  => $topic['subject_name'],
    ],
    'provider' => [
        '@type' => 'Organization',
        'name'  => 'Skoolyst MCQs',
        'url'   => htmlspecialchars(base_url(), ENT_QUOTES, 'UTF-8'),
    ],
    'interactivityType'   => 'active',
    'learningResourceType'=> 'quiz',
    'hasPart'             => $questionSchemas,
];
echo json_encode($practiceSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
</script>
<?php endif; ?>
@endsection

@section('content')
@include('components.breadcrumb', ['breadcrumbs' => [
    ['label' => 'Subjects', 'url' => route('subjects.index')],
    ['label' => $topic['subject_name'], 'url' => route('subjects.show', $topic['subject_slug'])],
    ['label' => $topic['name'], 'url' => route('topics.show', $topic['slug'])],
    ['label' => 'Practice', 'url' => '#'],
]])

<section class="sk-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h2 class="sk-section-title mb-0">Practice MCQs</h2>
                        <p class="sk-section-subtitle mb-0">{{ $topic['name'] }} — Instant feedback with explanations</p>
                    </div>
                    <a href="{{ route('topics.result', $topic['slug']) }}" class="btn btn-sk-outline btn-sm-sk"><i class="bi bi-clipboard-data me-1"></i>View Results</a>
                </div>

                @include('components.mcq-practice', [
                    'mcqs' => $mcqs,
                    'mcqOptions' => $mcqOptions,
                    'backUrl' => route('topics.show', $topic['slug']),
                    'backLabel' => 'Back to Topic',
                    'resultUrl' => route('topics.result', $topic['slug']),
                    'submitUrl' => is_authenticated() ? route('practice.submit', $topic['slug']) : null,
                ])
            </div>
        </div>
    </div>
</section>
@endsection
