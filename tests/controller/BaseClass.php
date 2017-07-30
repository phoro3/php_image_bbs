<?php
namespace Tests\controller;

use Slim\App;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Monolog\Handler\StreamHandler;

class BaseClass extends \PHPUnit_Framework_TestCase{
    protected $container;

    public function setUp(){
        $settings = require __DIR__ . '/../../src/settings.php';
        $app = new App($settings);

        $this->container = $app->getContainer();
        $this->container['db'] = function($c){
            $pdoMock = \Mockery::mock(\PDO::class);
            return $pdoMock;
        };
        $this->container['renderer'] = function ($c) {
            $settings = $c->get('settings')['renderer'];
            return new PhpRenderer($settings['template_path']);
        };
        $this->container['logger'] = function ($c) {
            $settings = $c->get('settings')['logger'];
            $logger = new Logger($settings['name']);
            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
            return $logger;
        };
    }

    public function tearDown(){
        \Mockery::close();
    }
}
