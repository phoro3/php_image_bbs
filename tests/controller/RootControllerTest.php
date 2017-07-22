<?php
use MyApp\controller\RootController;
use MyApp\model\Comments;
use Slim\App;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class RootControllerTest extends \PHPUnit_Framework_TestCase{
    private $container;

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
            $logger = new Monolog\Logger($settings['name']);
            $logger->pushProcessor(new Monolog\Processor\UidProcessor());
            $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
            return $logger;
        };
    }

    public function tearDown(){
        Mockery::close();
    }

    public function testShowCommentWhenException(){
        //Test when exception happens
        //Make mock for Comments class
        $commentMock = \Mockery::mock('overload:' . Comments::class);
        $commentMock
            ->shouldReceive('fetchAllComments')
            ->andThrow(new \PDOException());
        $controller = new RootController($this->container);
        $response = $controller->showComment(null, new Response(), null);
        $this->assertContains('エラーが発生しました', (string)$response->getBody());
    }

    /**
     * Test for showComment
     */
    public function testShowComment(){
        //Test normal route
        $expectedArray = array(
            array('comment' => 'test comment')
        );

        //Make mock for Comments class
        $commentMock = \Mockery::mock('overload:' . Comments::class);
        $commentMock
            ->shouldReceive('fetchAllComments')
            ->andReturn($expectedArray);

        $controller = new RootController($this->container);
        $response = $controller->showComment(null, new Response(), null);
        $this->assertContains('test comment', (string)$response->getBody());
    }

}

