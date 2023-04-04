<?php

use App\Connect;
use App\Table\PostTable;
use App\Auth;

Auth::check();

$pdo = Connect::getPDO();
$table = new PostTable($pdo);
$table->delete($params['id']);

header('Location: ' . $router->url('admin_posts'));
