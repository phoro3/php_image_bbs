<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link href='/css/style' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <h1>掲示板</h1>
        <?php foreach($comments as $c){ ?>
            <p><?= $c['comment'] ?></p>    
        <?php } ?>
    </body>
</html>
