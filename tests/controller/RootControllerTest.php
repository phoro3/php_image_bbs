<?php
namespace Tests\controller;

use MyApp\controller\RootController;
use MyApp\model\Comments;
use Tests\controller\BaseClass;
use Slim\Http\Response;

class RootControllerTest extends BaseClass{

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

