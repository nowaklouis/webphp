<?php
$title = "edition";

use App\Connect;
use App\Table\PostTable;
use Valitron\Validator;
use App\HTML\Form;
use App\Validators\PostValidator;

$pdo = Connect::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;
$errors = [];

if (!empty($_POST)) {
    Validator::lang('fr');
    $v = new PostValidator($_POST);

    if (empty($_POST)) {
        $errors['name'][] = 'Le champs titre ne peut etre vide';
    }
    $post
        ->setName($_POST['name'])
        ->setContent($_POST['content'])
        ->setSlug($_POST['slug'])
        ->setCreatedAt($_POST['created_at']);
    if ($v->validate()) {
        $postTable->update($post);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);

?>
<?php if ($success) : ?>
    <div class="alert alert-success">Article modifier</div>
<?php endif ?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">Article non modifier></div>
<?php endif ?>

<h1>Editer l'article <?= $post->getName() ?></h1>

<?php require '_form.php' ?>