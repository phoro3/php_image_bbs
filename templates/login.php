<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link href='/css/style' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <h1>掲示板</h1>
        <h2>ログイン</h2>
        <p>掲示板を利用するにはログインしてください</p>
        <p><?= $errorMessage ?></p>
        <form action="/login/auth" method="POST">
            <p>ID：<input type="text" name="userId"></p>
            <p>パスワード：<input type="password" name="password"></p>
            <p><input type="submit" value="ログイン"></p>
        </form>
    </body>
</html>
