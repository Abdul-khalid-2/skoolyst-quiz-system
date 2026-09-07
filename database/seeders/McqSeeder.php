<?php
declare(strict_types=1);

return function (PDO $pdo): void {
    $questions = [
        [
            'subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'easy',
            'question' => 'Which organelle is known as the powerhouse of the cell?',
            'explanation' => 'Mitochondria generate ATP through cellular respiration, earning them the nickname "powerhouse of the cell."',
            'options' => [['A', 'Nucleus', false], ['B', 'Mitochondria', true], ['C', 'Ribosome', false], ['D', 'Golgi apparatus', false]],
        ],
        [
            'subject' => 'chemistry', 'topic' => 'atmospheric-chemistry', 'difficulty' => 'medium',
            'question' => "What is the most abundant gas in Earth's atmosphere?",
            'explanation' => 'Nitrogen makes up about 78% of the atmosphere by volume.',
            'options' => [['A', 'Nitrogen', true], ['B', 'Oxygen', false], ['C', 'Carbon Dioxide', false], ['D', 'Argon', false]],
        ],
        [
            'subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'hard',
            'question' => 'Which enzyme breaks down starch into maltose in the digestive system?',
            'explanation' => 'Amylase, found in saliva and pancreatic secretions, hydrolyzes starch into maltose.',
            'options' => [['A', 'Amylase', true], ['B', 'Lipase', false], ['C', 'Pepsin', false], ['D', 'Trypsin', false]],
        ],
        [
            'subject' => 'mathematics', 'topic' => 'calculus', 'difficulty' => 'medium',
            'question' => 'What is the derivative of x² with respect to x?',
            'explanation' => 'Using the power rule, d/dx(x^n) = n·x^(n-1), so the derivative of x² is 2x.',
            'options' => [['A', 'x', false], ['B', '2x', true], ['C', 'x²', false], ['D', '2', false]],
        ],
        [
            'subject' => 'physics', 'topic' => 'electricity', 'difficulty' => 'medium',
            'question' => 'What is the SI unit of electric current?',
            'explanation' => 'The ampere (A) is the SI base unit of electric current.',
            'options' => [['A', 'Volt', false], ['B', 'Ampere', true], ['C', 'Ohm', false], ['D', 'Watt', false]],
        ],
        [
            'subject' => 'general-knowledge', 'topic' => 'geography', 'difficulty' => 'easy',
            'question' => 'Which planet is known as the Red Planet?',
            'explanation' => 'Mars appears red due to iron oxide (rust) on its surface.',
            'options' => [['A', 'Venus', false], ['B', 'Mars', true], ['C', 'Jupiter', false], ['D', 'Saturn', false]],
        ],
    ];

    $findSubject = $pdo->prepare('SELECT id FROM mcq_subjects WHERE slug = ?');
    $findTopic = $pdo->prepare('SELECT id FROM mcq_topics WHERE slug = ? AND subject_id = ?');
    $findExisting = $pdo->prepare('SELECT id FROM mcq_questions WHERE question_text = ? LIMIT 1');
    $insertMcq = $pdo->prepare(
        'INSERT INTO mcq_questions (subject_id, topic_id, question_text, explanation, difficulty, created_at, updated_at)
         VALUES (?, ?, ?, ?, ?, NOW(), NOW())'
    );
    $insertOption = $pdo->prepare(
        'INSERT INTO mcq_options (mcq_id, label, option_text, is_correct, sort_order) VALUES (?, ?, ?, ?, ?)'
    );

    foreach ($questions as $q) {
        $findExisting->execute([$q['question']]);
        if ($findExisting->fetchColumn()) continue;

        $findSubject->execute([$q['subject']]);
        $subjectId = $findSubject->fetchColumn();
        if (!$subjectId) continue;

        $findTopic->execute([$q['topic'], $subjectId]);
        $topicId = $findTopic->fetchColumn() ?: null;

        $insertMcq->execute([$subjectId, $topicId, $q['question'], $q['explanation'], $q['difficulty']]);
        $mcqId = (int) $pdo->lastInsertId();

        foreach ($q['options'] as $order => $option) {
            [$label, $text, $isCorrect] = $option;
            $insertOption->execute([$mcqId, $label, $text, $isCorrect ? 1 : 0, $order]);
        }
    }
};
