<?php
declare(strict_types=1);

return function (PDO $pdo): void {
    $subjects = [
        ['name' => 'Biology', 'slug' => 'biology', 'icon' => 'bi-tree', 'icon_bg' => 'bg-icon-success', 'description' => 'Cell biology, genetics, human physiology, ecology, and plant biology.'],
        ['name' => 'Chemistry', 'slug' => 'chemistry', 'icon' => 'bi-flask', 'icon_bg' => 'bg-icon-info', 'description' => 'Organic, inorganic, physical chemistry, periodic table, and chemical reactions.'],
        ['name' => 'Physics', 'slug' => 'physics', 'icon' => 'bi-atom', 'icon_bg' => 'bg-icon-navy', 'description' => 'Mechanics, electricity, magnetism, optics, thermodynamics, and modern physics.'],
        ['name' => 'Mathematics', 'slug' => 'mathematics', 'icon' => 'bi-calculator', 'icon_bg' => 'bg-icon-gold', 'description' => 'Algebra, calculus, geometry, trigonometry, and statistics.'],
        ['name' => 'English', 'slug' => 'english', 'icon' => 'bi-translate', 'icon_bg' => 'bg-icon-cyan', 'description' => 'Grammar, vocabulary, reading comprehension, and sentence correction.'],
        ['name' => 'General Knowledge', 'slug' => 'general-knowledge', 'icon' => 'bi-globe-americas', 'icon_bg' => 'bg-icon-success', 'description' => 'World history, geography, current affairs, and Pakistan studies.'],
        ['name' => 'Computer Science', 'slug' => 'computer-science', 'icon' => 'bi-keyboard', 'icon_bg' => 'bg-icon-navy', 'description' => 'Programming concepts, data structures, algorithms, and computer fundamentals.'],
        ['name' => 'Urdu', 'slug' => 'urdu', 'icon' => 'bi-pen', 'icon_bg' => 'bg-icon-gold', 'description' => 'Urdu grammar, vocabulary, poetry, and literature comprehension.'],
        ['name' => 'Islamic Studies', 'slug' => 'islamic-studies', 'icon' => 'bi-moon-stars', 'icon_bg' => 'bg-icon-success', 'description' => 'Quran, Hadith, Islamic history, and basic Islamic concepts.'],
    ];

    $stmt = $pdo->prepare(
        'INSERT IGNORE INTO mcq_subjects (name, slug, description, icon, icon_bg, created_at, updated_at)
         VALUES (:name, :slug, :description, :icon, :icon_bg, NOW(), NOW())'
    );

    foreach ($subjects as $subject) {
        $stmt->execute($subject);
    }
};
