<?php
use MyApp\controller\RootController;
use MyApp\controller\SignUpController;

$app->get('/', RootController::class . ':showComment');

$app->get('/signup', function($request, $response, $args){
    return $this->renderer->render($response, 'signup.php');
});

$app->post('/signup/add', SignUpController::class . ':addUser');

$app->get('/css/{filename}', function($request, $response, $args){
    $newResponse = $response->withHeader('Content-type', 'text/css');
    return $this->renderer->render($newResponse, 'css/' . $args['filename'] . '.css');
});

