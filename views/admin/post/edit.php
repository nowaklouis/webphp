<?php
$title = "edition";

use App\Connect;
use App\Table\PostTable;
use Valitron\Validator;

$pdo = Connect::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;
$errors = [];

if (!empty($_POST)) {
    Validator::lang('fr');
    $v = new Validator($_POST);
    $v->labels(array(
        'name' => 'Titre',
        'content' => 'contenu'
    ));
    $v->rule('required', 'name');
    if (empty($_POST)) {
        $errors['name'][] = 'Le champs titre ne peut etre vide';
    }
    $post->setName($_POST['name']);
    if ($v->validate()) {
        $postTable->update($post);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

?>
<?php if ($success) : ?>
    <div class="alert alert-success">Article modifier</div>
<?php endif ?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">Article non modifier></div>
<?php endif ?>

<h1>Editer l'article <?= $post->getName() ?></h1>

<form action="" method="POST">
    <div class="form-group">
        <label for="name">Titre</label>
        <input type="text" class="form-control" <?= isset($errors['name']) ? 'is-invalide' : '' ?> name="name" value="<?= $post->getName() ?>" required>
        <?php if (isset($errors['name'])) : ?>
            <div class="invalid-feedback">
                mauvaise saisie
            </div>
        <?php endif ?>
    </div>
    <button class="btn btn-primary">Modifier</button>
</form>