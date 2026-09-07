<?php
declare(strict_types=1);

return function (PDO $pdo): void {
    $testTypes = [
        ['name' => 'MDCAT', 'slug' => 'mdcat', 'icon' => 'bi-heart-pulse', 'badge_class' => 'sk-badge-navy', 'description' => 'Medical and Dental College Admission Test preparation with comprehensive MCQs.'],
        ['name' => 'ECAT', 'slug' => 'ecat', 'icon' => 'bi-cpu', 'badge_class' => 'sk-badge-cyan', 'description' => 'Engineering College Admission Test practice with physics, math, and chemistry MCQs.'],
        ['name' => 'School Exams', 'slug' => 'school', 'icon' => 'bi-backpack', 'badge_class' => 'sk-badge-gold', 'description' => 'Practice MCQs for school-level exams across all major subjects and grade levels.'],
        ['name' => 'English', 'slug' => 'english', 'icon' => 'bi-translate', 'badge_class' => 'sk-badge-light', 'description' => 'English language proficiency MCQs covering grammar, vocabulary, comprehension, and sentence correction.'],
        ['name' => 'General Knowledge', 'slug' => 'general-knowledge', 'icon' => 'bi-globe-americas', 'badge_class' => 'sk-badge-light', 'description' => 'World history, geography, current affairs, Pakistan studies, and everyday science MCQs.'],
    ];

    $stmt = $pdo->prepare(
        'INSERT IGNORE INTO mcq_test_types (name, slug, description, icon, badge_class, created_at, updated_at)
         VALUES (:name, :slug, :description, :icon, :badge_class, NOW(), NOW())'
    );

    foreach ($testTypes as $testType) {
        $stmt->execute($testType);
    }
};
