<?php
use MyApp\model\DbConnector;

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//database
$container['db'] = function ($c) {
    $filename = __DIR__ . '/../conf/ini/database.ini';
    $passwordFilename = __DIR__ . '/../conf/ini/password.ini';
    $connector = new DbConnector();
    $pdo = $connector->connect($filename, $passwordFilename);
    return $pdo;
};
