<?php
use MyApp\controller\Root;

$app->get('/', Root::class . ':showComment');

$app->get('/comment/add', MyApp\controller\Root::class . ':addComment');


$app->get('/css/{filename}', function($request, $response, $args){
    $newResponse = $response->withHeader('Content-type', 'text/css');
    return $this->renderer->render($newResponse, 'css/' . $args['filename'] . '.css');
});

