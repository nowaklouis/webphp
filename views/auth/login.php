<?php

use App\Model\User;
use App\HTML\Form;
use App\Connect;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

$user = new User();
$errors = [];

if (!empty($_POST)) {
    $user->setUsername($_POST['username']);
    $errors['password'] = 'Identifiant ou mot de passe incorrect';

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $table = new UserTable(Connect::getPDO());
        try {
            $userFull = $table->findByUsername($_POST['username']);
            if (password_verify($_POST['password'], $userFull->getPassword()) === true) {
                session_start();
                $_SESSION['auth'] = $userFull->getId();
                header('Location: ' . $router->url('admin_posts'));
                exit();
            }
        } catch (NotFoundException $e) {
        }
    }
}
$form = new Form($user, $errors);



?>

<h1>Connexion</h1>

<form action="" method="POST">
    <?= $form->input('username', 'Nom d\'Utilisateur'); ?>
    <?= $form->inputPassword('password', 'Mot de passe'); ?>
    <button type="submit" class="btn btn-primary">se Connecter</button>
</form>