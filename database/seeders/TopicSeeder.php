<?php
declare(strict_types=1);

return function (PDO $pdo): void {
    $topics = [
        'biology' => [
            ['name' => 'Cell Biology', 'slug' => 'cell-biology', 'icon' => 'bi-dna', 'difficulty' => 'easy'],
            ['name' => 'Genetics', 'slug' => 'genetics', 'icon' => 'bi-gender-male', 'difficulty' => 'medium'],
            ['name' => 'Human Physiology', 'slug' => 'human-physiology', 'icon' => 'bi-clipboard2-pulse', 'difficulty' => 'medium'],
            ['name' => 'Digestive System', 'slug' => 'digestive-system', 'icon' => 'bi-lungs', 'difficulty' => 'hard'],
            ['name' => 'Circulatory System', 'slug' => 'circulatory-system', 'icon' => 'bi-heart', 'difficulty' => 'easy'],
            ['name' => 'Ecology', 'slug' => 'ecology', 'icon' => 'bi-globe2', 'difficulty' => 'medium'],
            ['name' => 'Plant Biology', 'slug' => 'plant-biology', 'icon' => 'bi-flower1', 'difficulty' => 'easy'],
            ['name' => 'Microbiology', 'slug' => 'microbiology', 'icon' => 'bi-bug', 'difficulty' => 'hard'],
        ],
        'chemistry' => [
            ['name' => 'Organic Chemistry', 'slug' => 'organic-chemistry', 'icon' => 'bi-droplet', 'difficulty' => 'medium'],
            ['name' => 'Periodic Table', 'slug' => 'periodic-table', 'icon' => 'bi-grid-3x3', 'difficulty' => 'easy'],
            ['name' => 'Atmospheric Chemistry', 'slug' => 'atmospheric-chemistry', 'icon' => 'bi-cloud', 'difficulty' => 'medium'],
        ],
        'physics' => [
            ['name' => 'Electricity & Magnetism', 'slug' => 'electricity', 'icon' => 'bi-lightning-charge', 'difficulty' => 'medium'],
        ],
        'mathematics' => [
            ['name' => 'Calculus', 'slug' => 'calculus', 'icon' => 'bi-graph-up', 'difficulty' => 'medium'],
        ],
        'english' => [
            ['name' => 'English Grammar', 'slug' => 'english-grammar', 'icon' => 'bi-book', 'difficulty' => 'easy'],
            ['name' => 'English Comprehension', 'slug' => 'english-comprehension', 'icon' => 'bi-book', 'difficulty' => 'medium'],
        ],
        'general-knowledge' => [
            ['name' => 'Geography', 'slug' => 'geography', 'icon' => 'bi-geo-alt', 'difficulty' => 'easy'],
        ],
    ];

    $findSubject = $pdo->prepare('SELECT id FROM mcq_subjects WHERE slug = ?');
    $insert = $pdo->prepare(
        'INSERT IGNORE INTO mcq_topics (subject_id, name, slug, icon, difficulty, created_at, updated_at)
         VALUES (:subject_id, :name, :slug, :icon, :difficulty, NOW(), NOW())'
    );

    foreach ($topics as $subjectSlug => $subjectTopics) {
        $findSubject->execute([$subjectSlug]);
        $subjectId = $findSubject->fetchColumn();
        if (!$subjectId) continue;

        foreach ($subjectTopics as $topic) {
            $insert->execute([
                'subject_id' => $subjectId,
                'name' => $topic['name'],
                'slug' => $topic['slug'],
                'icon' => $topic['icon'],
                'difficulty' => $topic['difficulty'],
            ]);
        }
    }
};
