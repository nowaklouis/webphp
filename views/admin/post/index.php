<?php

use App\Connect;
use App\Table\PostTable;

$title = 'administration';

$pdo = Connect::getPDO();
$link = $router->url('admin_posts');
list($posts, $pagination) = (new PostTable($pdo))->findPaginated();
?>

<?php if (isset($_GET['delete'])) : ?>
    <div class="alert alert-success">Suppression effectuer</div>
<?php endif ?>


<table class="table table-striped">
    <thead>
        <th>#</th>
        <th>Titre</th>
        <th>
            <a href="<?= $router->url('admin_post_new') ?>" class="btn btn-primary">Nouveau</a>
        </th>
    </thead>
    <tbody>
        <?php foreach ($posts as $post) : ?>
            <tr>
                <td>#<?= $post->getId() ?></td>
                <td>
                    <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>"><?= htmlentities($post->getName()) ?></a>
                </td>
                <td>
                    <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>" class="btn btn-primary">Editer</a>
                    <form action="<?= $router->url('admin_post_delete', ['id' => $post->getId()]) ?>" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette article ?')" style="display:inline">
                        <button type="submit" class="btn btn-danger">Suppr</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link); ?>
    <?= $pagination->nextLink($link); ?>
</div>