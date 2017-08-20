<?php
use MyApp\controller\RootController;
use MyApp\controller\SignUpController;
use MyApp\controller\AuthController;
use MyApp\controller\CommentController;
use MyApp\middleware\LoginMiddleware;

$app->get('/', RootController::class . ':showComment')
    ->add(new LoginMiddleware());

$app->get('/signup', function($request, $response, $args){
    return $this->renderer->render($response, 'signup.php');
});
$app->post('/signup/add', SignUpController::class . ':addUser');

$app->get('/login', function($request, $response, $args){
    return $this->renderer->render($response, 'login.php');
});
$app->post('/login/auth', AuthController::class . ':login');
$app->get('/logout', AuthController::class . ':logout');

$app->post('/comment/add', CommentController::class . ':addComment');

$app->get('/css/{filename}', function($request, $response, $args){
    $newResponse = $response->withHeader('Content-type', 'text/css');
    return $this->renderer->render($newResponse, 'css/' . $args['filename'] . '.css');
});

$app->get('/img/{filename}', function($request, $response, $args){
    $newResponse = $response->withHeader('Content-type', 'image/jpeg');
    return $this->renderer->render($newResponse, 'img/' . $args['filename'] .'.jpg');
});
