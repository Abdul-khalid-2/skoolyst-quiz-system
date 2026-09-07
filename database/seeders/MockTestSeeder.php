<?php
declare(strict_types=1);

return function (PDO $pdo): void {
    $mockTests = [
        [
            'test_type' => 'mdcat', 'title' => 'MDCAT Full Mock Test #1', 'slug' => 'mdcat-full-mock-test-1',
            'description' => 'Complete MDCAT simulation with all four subjects. Real exam experience with timer, question palette, and detailed performance analysis.',
            'total_questions' => 200, 'duration_minutes' => 210, 'difficulty' => 'medium',
            'passing_score_percent' => 50, 'negative_marking' => 0, 'is_featured' => 1,
            'questions' => ['Which organelle is known as the powerhouse of the cell?', 'What is the SI unit of electric current?'],
        ],
        [
            'test_type' => 'ecat', 'title' => 'ECAT Engineering Mock Test', 'slug' => 'ecat-engineering-mock-test',
            'description' => 'Full ECAT practice test covering Physics, Math, Chemistry, and English.',
            'total_questions' => 100, 'duration_minutes' => 150, 'difficulty' => 'hard',
            'passing_score_percent' => 50, 'negative_marking' => 0, 'is_featured' => 0,
            'questions' => ['What is the derivative of x² with respect to x?', 'What is the SI unit of electric current?'],
        ],
        [
            'test_type' => 'school', 'title' => 'Biology Chapter Test', 'slug' => 'biology-chapter-test',
            'description' => 'Focused test on Cell Biology and Human Physiology for school students.',
            'total_questions' => 50, 'duration_minutes' => 60, 'difficulty' => 'easy',
            'passing_score_percent' => 50, 'negative_marking' => 0, 'is_featured' => 0,
            'questions' => ['Which organelle is known as the powerhouse of the cell?', 'Which enzyme breaks down starch into maltose in the digestive system?'],
        ],
        [
            'test_type' => 'english', 'title' => 'English Proficiency Test', 'slug' => 'english-proficiency-test',
            'description' => 'Assess your grammar, vocabulary, and comprehension skills.',
            'total_questions' => 60, 'duration_minutes' => 60, 'difficulty' => 'easy',
            'passing_score_percent' => 50, 'negative_marking' => 0, 'is_featured' => 0,
            'questions' => [],
        ],
    ];

    $findTestType = $pdo->prepare('SELECT id FROM mcq_test_types WHERE slug = ?');
    $findMcq = $pdo->prepare('SELECT id FROM mcq_questions WHERE question_text = ? LIMIT 1');
    $insertMockTest = $pdo->prepare(
        'INSERT IGNORE INTO mcq_mock_tests
         (test_type_id, title, slug, description, total_questions, duration_minutes, difficulty, passing_score_percent, negative_marking, is_featured, created_at, updated_at)
         VALUES (:test_type_id, :title, :slug, :description, :total_questions, :duration_minutes, :difficulty, :passing_score_percent, :negative_marking, :is_featured, NOW(), NOW())'
    );
    $findMockTest = $pdo->prepare('SELECT id FROM mcq_mock_tests WHERE slug = ?');
    $linkQuestion = $pdo->prepare(
        'INSERT IGNORE INTO mcq_mock_test_questions (mock_test_id, mcq_id, sort_order) VALUES (?, ?, ?)'
    );

    foreach ($mockTests as $mockTest) {
        $findTestType->execute([$mockTest['test_type']]);
        $testTypeId = $findTestType->fetchColumn();
        if (!$testTypeId) continue;

        $insertMockTest->execute([
            'test_type_id' => $testTypeId,
            'title' => $mockTest['title'],
            'slug' => $mockTest['slug'],
            'description' => $mockTest['description'],
            'total_questions' => $mockTest['total_questions'],
            'duration_minutes' => $mockTest['duration_minutes'],
            'difficulty' => $mockTest['difficulty'],
            'passing_score_percent' => $mockTest['passing_score_percent'],
            'negative_marking' => $mockTest['negative_marking'],
            'is_featured' => $mockTest['is_featured'],
        ]);

        $findMockTest->execute([$mockTest['slug']]);
        $mockTestId = $findMockTest->fetchColumn();
        if (!$mockTestId) continue;

        foreach ($mockTest['questions'] as $order => $questionText) {
            $findMcq->execute([$questionText]);
            $mcqId = $findMcq->fetchColumn();
            if ($mcqId) {
                $linkQuestion->execute([$mockTestId, $mcqId, $order]);
            }
        }
    }
};
