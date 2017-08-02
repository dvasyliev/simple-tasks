<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/app/view/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/app/view/node_modules/bootstrap/dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/app/view/src/css/main.css">
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Simple Tasks</a>
                <?php if( !$is_logged ): ?>
                    <a href="/admin/login" class="navbar-btn btn btn-success">Войти как администратор</a>
                <?php else: ?>
                    <a href="/admin/logout" class="navbar-btn btn btn-success">Выйти</a>
                    <span class="navbar-text">Вы вошли, как <b><?= $login ?></b></span>
                <?php endif; ?>
            </div>
        </div>
    </div>