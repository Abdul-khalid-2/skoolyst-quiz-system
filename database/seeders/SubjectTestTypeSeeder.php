<?php
declare(strict_types=1);

return function (PDO $pdo): void {
    $links = [
        'mdcat' => ['biology', 'chemistry', 'physics', 'english'],
        'ecat' => ['physics', 'mathematics', 'chemistry', 'english'],
        'school' => ['biology', 'chemistry', 'physics', 'mathematics', 'english', 'general-knowledge', 'computer-science', 'urdu'],
        'english' => ['english'],
        'general-knowledge' => ['general-knowledge', 'islamic-studies'],
    ];

    $findTestType = $pdo->prepare('SELECT id FROM mcq_test_types WHERE slug = ?');
    $findSubject = $pdo->prepare('SELECT id FROM mcq_subjects WHERE slug = ?');
    $link = $pdo->prepare('INSERT IGNORE INTO mcq_subject_test_type (subject_id, test_type_id, created_at) VALUES (?, ?, NOW())');

    foreach ($links as $testTypeSlug => $subjectSlugs) {
        $findTestType->execute([$testTypeSlug]);
        $testTypeId = $findTestType->fetchColumn();
        if (!$testTypeId) continue;

        foreach ($subjectSlugs as $subjectSlug) {
            $findSubject->execute([$subjectSlug]);
            $subjectId = $findSubject->fetchColumn();
            if (!$subjectId) continue;

            $link->execute([$subjectId, $testTypeId]);
        }
    }
};
