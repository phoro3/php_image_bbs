<?php
use MyApp\controller\RootController;
use MyApp\controller\SignUpController;
use MyApp\controller\AuthController;

$app->get('/', RootController::class . ':showComment');

$app->get('/signup', function($request, $response, $args){
    return $this->renderer->render($response, 'signup.php');
});
$app->post('/signup/add', SignUpController::class . ':addUser');

$app->get('/login', function($request, $response, $args){
    return $this->renderer->render($response, 'login.php');
});
$app->post('/login/auth', AuthController::class . ':login');
$app->get('/logout', AuthController::class . ':logout');

$app->get('/css/{filename}', function($request, $response, $args){
    $newResponse = $response->withHeader('Content-type', 'text/css');
    return $this->renderer->render($newResponse, 'css/' . $args['filename'] . '.css');
});

