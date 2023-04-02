<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use App\Connect;

$pdo = Connect::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

for ($i = 0; $i < 50; $i++) {
    $pdo->exec("INSERT INTO post SET name='Article #$i', slug='artcil$i', content='lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem lorem ', created_at='2020-12-24 15:00:00'");
    $posts[] = $pdo->lastInsertId();
}

for ($i = 0; $i < 5; $i++) {
    $pdo->exec("INSERT INTO category SET name='Article #$i', slug='artcile$i'");
    $categories[] = $pdo->lastInsertId();
}

foreach ($posts as $post) {
    foreach ($categories as $category) {
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");
    }
}

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET username='admin', password='$password'");
