<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title><?= $title ?? 'Mon site' ?></title>
</head>

<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="/" class="navbar-brand">The Site</a>
        <a href="/login" class="navbar-brand">Authentification</a>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>
    <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
            Page generer en <?= 1000 * (microtime(true) - DEBUG_TIME) ?> ms
        </div>

    </footer>

</body>

</html>