<?php

use App\Helpers\Text;
use App\Model\Post;
use App\Connect;
use App\URL;

$title = 'Mon Blog';

$pdo = Connect::getPDO();

$currentPage = URL::getPositiveInt('page', 1);

if ($currentPage <= 0) {
    throw new Exception('numero de page invalide');
}

$count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];
$perPage = 12;
$pages = ceil($count / $perPage);
if ($currentPage > $pages) {
    throw new Exception('numero de page invalide');
}

$offset = $perPage * ($currentPage - 1);
$query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);

?>
<h1>Mon Blog</h1>

<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-md-3">
            <?php require 'card.php' ?>
        </div>
    <?php endforeach ?>
</div>
<div class="d-flex justify-content-between my-4">
    <?php if ($currentPage > 1) : ?>
        <?php
        $link = $router->url('home');
        if ($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
        ?>
        <a href="<?= $link ?>" class="btn btn-primary">&laquo; Page Précédente</a>
    <?php endif ?>
    <?php if ($currentPage < $pages) : ?>
        <a href="<?= $router->url('home') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary ml-auto">Page Suivante &raquo;</a>
    <?php endif ?>
</div>