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
        <form id="comment" action="/comment/add" method="POST">
            <p><?= $_SESSION['errorMessage'] ?></p>
            <textarea id="comment" name="comment" cols="40" rows="4"></textarea>
            <p><input type="submit" value="送信"></p>
        </form>
        <h1>投稿一覧</h1>
        <?php foreach($comments as $c){ ?>
            <p>
                <?= $c['comment'] ?>
                <?php if (empty($c['image_path']) === false) { ?>
                <img src="img/<?= $c['image_path'] ?>" width="100" height="100">
                <?php } ?>
            </p>    
            <p>投稿者：<?= $c['name'] ?></p>
        <?php } ?>
    </body>
</html>
<?php
    $_SESSION['errorMessage'] = '';
?>
