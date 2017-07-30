<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link href='/css/style' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <h1>掲示板</h1>
        <p><?= $errorMessage ?></p>
        <form action="/signup/add" method="POST">
            <p>ID：<input type="text" name="userId"></p>
            <p>パスワード：<input type="password" name="password"></p>
            <p>ニックネーム：<input type="text" name="name"></p>
            <p><input type="submit" value="登録"></p>
        </form>
    </body>
</html>
