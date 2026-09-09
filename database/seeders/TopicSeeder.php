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
            ['name' => 'Chemical Bonding', 'slug' => 'chemical-bonding', 'icon' => 'bi-diagram-2', 'difficulty' => 'medium'],
            ['name' => 'Acids & Bases', 'slug' => 'acids-and-bases', 'icon' => 'bi-eyedropper', 'difficulty' => 'medium'],
            ['name' => 'Inorganic Chemistry', 'slug' => 'inorganic-chemistry', 'icon' => 'bi-gem', 'difficulty' => 'medium'],
        ],
        'physics' => [
            ['name' => 'Electricity & Magnetism', 'slug' => 'electricity', 'icon' => 'bi-lightning-charge', 'difficulty' => 'medium'],
            ['name' => 'Mechanics', 'slug' => 'mechanics', 'icon' => 'bi-gear', 'difficulty' => 'medium'],
            ['name' => 'Optics', 'slug' => 'optics', 'icon' => 'bi-brightness-high', 'difficulty' => 'medium'],
            ['name' => 'Thermodynamics', 'slug' => 'thermodynamics', 'icon' => 'bi-thermometer-half', 'difficulty' => 'medium'],
            ['name' => 'Modern Physics', 'slug' => 'modern-physics', 'icon' => 'bi-atom', 'difficulty' => 'hard'],
            ['name' => 'Magnetism', 'slug' => 'magnetism', 'icon' => 'bi-magnet', 'difficulty' => 'medium'],
        ],
        'mathematics' => [
            ['name' => 'Calculus', 'slug' => 'calculus', 'icon' => 'bi-graph-up', 'difficulty' => 'medium'],
            ['name' => 'Algebra', 'slug' => 'algebra', 'icon' => 'bi-calculator', 'difficulty' => 'easy'],
            ['name' => 'Geometry', 'slug' => 'geometry', 'icon' => 'bi-triangle', 'difficulty' => 'medium'],
            ['name' => 'Trigonometry', 'slug' => 'trigonometry', 'icon' => 'bi-triangle-half', 'difficulty' => 'medium'],
            ['name' => 'Statistics', 'slug' => 'statistics', 'icon' => 'bi-bar-chart', 'difficulty' => 'medium'],
            ['name' => 'Number Theory', 'slug' => 'number-theory', 'icon' => 'bi-123', 'difficulty' => 'easy'],
        ],
        'english' => [
            ['name' => 'English Grammar', 'slug' => 'english-grammar', 'icon' => 'bi-book', 'difficulty' => 'easy'],
            ['name' => 'English Comprehension', 'slug' => 'english-comprehension', 'icon' => 'bi-book', 'difficulty' => 'medium'],
            ['name' => 'Vocabulary', 'slug' => 'vocabulary', 'icon' => 'bi-journal-text', 'difficulty' => 'easy'],
            ['name' => 'Idioms & Phrases', 'slug' => 'idioms-and-phrases', 'icon' => 'bi-chat-quote', 'difficulty' => 'medium'],
        ],
        'general-knowledge' => [
            ['name' => 'Geography', 'slug' => 'geography', 'icon' => 'bi-geo-alt', 'difficulty' => 'easy'],
            ['name' => 'World History', 'slug' => 'world-history', 'icon' => 'bi-clock-history', 'difficulty' => 'medium'],
            ['name' => 'Pakistan Studies', 'slug' => 'pakistan-studies', 'icon' => 'bi-flag', 'difficulty' => 'easy'],
            ['name' => 'Current Affairs', 'slug' => 'current-affairs', 'icon' => 'bi-newspaper', 'difficulty' => 'medium'],
            ['name' => 'Sports', 'slug' => 'sports', 'icon' => 'bi-trophy', 'difficulty' => 'easy'],
        ],
        'computer-science' => [
            ['name' => 'Programming Fundamentals', 'slug' => 'programming-fundamentals', 'icon' => 'bi-code-slash', 'difficulty' => 'easy'],
            ['name' => 'Data Structures', 'slug' => 'data-structures', 'icon' => 'bi-diagram-3', 'difficulty' => 'medium'],
            ['name' => 'Computer Networks', 'slug' => 'computer-networks', 'icon' => 'bi-hdd-network', 'difficulty' => 'medium'],
            ['name' => 'Operating Systems', 'slug' => 'operating-systems', 'icon' => 'bi-cpu', 'difficulty' => 'medium'],
            ['name' => 'Databases', 'slug' => 'databases', 'icon' => 'bi-database', 'difficulty' => 'medium'],
            ['name' => 'Algorithms', 'slug' => 'algorithms', 'icon' => 'bi-list-ol', 'difficulty' => 'hard'],
        ],
        'urdu' => [
            ['name' => 'Urdu Grammar', 'slug' => 'urdu-grammar', 'icon' => 'bi-pen', 'difficulty' => 'easy'],
            ['name' => 'Urdu Literature', 'slug' => 'urdu-literature', 'icon' => 'bi-book-half', 'difficulty' => 'medium'],
            ['name' => 'Urdu Vocabulary', 'slug' => 'urdu-vocabulary', 'icon' => 'bi-journal-text', 'difficulty' => 'easy'],
        ],
        'islamic-studies' => [
            ['name' => 'Quran & Hadith', 'slug' => 'quran-and-hadith', 'icon' => 'bi-book', 'difficulty' => 'medium'],
            ['name' => 'Pillars of Islam', 'slug' => 'pillars-of-islam', 'icon' => 'bi-moon-stars', 'difficulty' => 'easy'],
            ['name' => 'Islamic History', 'slug' => 'islamic-history', 'icon' => 'bi-clock-history', 'difficulty' => 'medium'],
            ['name' => 'Prophets of Islam', 'slug' => 'prophets-of-islam', 'icon' => 'bi-star', 'difficulty' => 'medium'],
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
