<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link href='/css/style' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <a href="/logout">ログアウト</a>
        <h1>掲示板</h1>
        <p>ようこそ<?= $_SESSION['name'] ?>さん</p>
        <?php foreach($comments as $c){ ?>
            <p><?= $c['comment'] ?></p>    
        <?php } ?>
    </body>
</html>
