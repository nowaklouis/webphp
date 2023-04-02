<?php

use App\Table\CategoryTable;
use App\Connect;
use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connect::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = $categoryTable->find($id);

if ($category->getSLUG() !== $slug) {
    $url = $router->url('category', ['slug' => $category->getSLUG(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}
$title = "Ma categorie {$category->getNAME()}";

list($posts, $paginatedQuery) = (new PostTable($pdo))->findPaginatedForCategory($category->getID());

$link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSLUG()]);
?>

<h1>Ma Categorie <?= $category->getNAME() ?></h1>

<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-md-3">
            <?php require dirname(__DIR__) . '/post/card.php' ?>
        </div>
    <?php endforeach ?>
</div>
<div class="d-flex justify-content-between my-4">
    <?= $paginatedQuery->previousLink($link); ?>
    <?= $paginatedQuery->nextLink($link); ?>
</div>