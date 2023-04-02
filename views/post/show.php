<?php

use App\Connect;
use App\Model\Post;
use App\Model\Category;

$title = 'L\'article';
$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connect::getPDO();
$query = $pdo->prepare('SELECT * FROM post WHERE id= :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
$post = $query->fetch();

if ($post === false) {
    throw new Exception('Aucun article correspondant');
}

if ($post->getSlug() !== $slug) {
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}

$query = $pdo->prepare('
SELECT c.id, c.slug, c.name 
FROM post_category pc 
JOIN category c ON pc.category_id = c.id 
WHERE pc.post_id = :id');
$query->execute(['id' => $post->getId()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
$categories = $query->fetchAll();
?>


<div class="card-body">
    <h1 class="card-title"><?= htmlentities($post->getName()) ?></h1>
    <p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>
    <?php foreach ($categories as $category) : ?>
        <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSLUG()]) ?>"><?= htmlentities($category->getNAME()) ?></a>
    <?php endforeach ?>
    <p><?= $post->getFormattedContent() ?></p>
</div>