<?php
$title = "Creation";

use App\Connect;
use App\Table\PostTable;
use Valitron\Validator;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\Model\Post;

$errors = [];
$post = new Post();
$post->setCreatedAt(date('Y-m-d H:i:s'));


if (!empty($_POST)) {

    $pdo = Connect::getPDO();
    $postTable = new PostTable($pdo);
    Validator::lang('fr');
    $v = new PostValidator($_POST);

    $post
        ->setName($_POST['name'])
        ->setContent($_POST['content'])
        ->setSlug($_POST['slug'])
        ->setCreatedAt($_POST['created_at']);
    if ($v->validate()) {
        $postTable->create($post);
        header('Location:' . $router->url('admin_posts'));
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);

?>

<?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">Article non enregistrer></div>
<?php endif ?>

<h1>Creation d'un article </h1>

<?php require '_form.php' ?>