<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.php', $args);
});

$app->get('/css/{filename}', function($request, $response, $args){
    $newResponse = $response->withHeader('Content-type', 'text/css');
    return $this->renderer->render($newResponse, 'css/' . $args['filename'] . '.css');
});

