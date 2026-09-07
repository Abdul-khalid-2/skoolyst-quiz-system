<?php
declare(strict_types=1);

// Root seeder: orchestrates all other seeders, in dependency order.
return function (PDO $pdo): void {
    (require __DIR__ . '/UserSeeder.php')($pdo);
    (require __DIR__ . '/SubjectSeeder.php')($pdo);
    (require __DIR__ . '/TestTypeSeeder.php')($pdo);
    (require __DIR__ . '/SubjectTestTypeSeeder.php')($pdo);
    (require __DIR__ . '/TopicSeeder.php')($pdo);
    (require __DIR__ . '/McqSeeder.php')($pdo);
    (require __DIR__ . '/MockTestSeeder.php')($pdo);
};
