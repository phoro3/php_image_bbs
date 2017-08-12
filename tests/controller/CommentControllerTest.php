<?php
namespace Tests\controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Tests\controller\BaseClass;
use MyApp\controller\CommentController;
use MyApp\model\User;
use MyApp\model\Comments;

class CommentControllerTest extends BaseClass{

    /**
     * Test for addComment
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testAddComments(){
        $controller = new CommentController($this->container);

        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/comment/add'
            ]
        );

        //Prepare request parameters
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'comment' => 'test'
        );
        $request = $request->withParsedBody($params);

        //Prepare test data
        $_SESSION['userId'] = 'testUser';
        $userNumId = 1;

        //Create mocks
        $userMock = \Mockery::mock('overload:' . User::class);
        $userMock
            ->shouldReceive('searchUserNumIdById')
            ->with($_SESSION['userId'])
            ->andReturn($userNumId);
        $commentMock = \Mockery::mock('overload:' . Comments::class);
        $commentMock
            ->shouldReceive('insertComment')
            ->with($userNumId, $params['comment']);
        $response = $controller->addComment($request, new Response(), null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Test for addComment when invalid inputs are given
     */
    public function testAddCommentsWithInvalidInput(){
        $controller = new CommentController($this->container);

        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/comment/add'
            ]
        );

        //When comment is null
        //Prepare request parameters
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'comment' => null
        );
        $request = $request->withParsedBody($params);

        //Clear session data
        $_SESSION['errorMessage'] = null;
        $this->assertNull($_SESSION['errorMessage']);

        $response = $controller->addComment($request, new Response(), null);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertContains('何も入力されていません', $_SESSION['errorMessage']);

        //When comment is empty string
        //Prepare request parameters
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'comment' => ''
        );
        $request = $request->withParsedBody($params);

        //Clear session data
        $_SESSION['errorMessage'] = null;
        $this->assertNull($_SESSION['errorMessage']);

        $response = $controller->addComment($request, new Response(), null);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('何も入力されていません', $_SESSION['errorMessage']);
    }

    /**
     * Test for addComment when exception happens
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testAddCommentsWithException(){
        $controller = new CommentController($this->container);

        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/comment/add'
            ]
        );

        //Prepare request parameters
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'comment' => 'test'
        );
        $request = $request->withParsedBody($params);

        //Prepare test data
        $_SESSION['userId'] = 'testUser';
        $userNumId = 1;

        //When exception happens at User class
        //Create mock
        $userMock = \Mockery::mock('overload:' . User::class);
        $userMock
            ->shouldReceive('searchUserNumIdById')
            ->with($_SESSION['userId'])
            ->andThrow(new \PDOException());
        $response = $controller->addComment($request, new Response(), null);
        $this->assertContains('エラーが発生しました', (string)$response->getBody());

        //When exception happens at Comments class
        //Create mock
        $userMock = \Mockery::mock('overload:' . User::class);
        $userMock
            ->shouldReceive('searchUserNumIdById')
            ->with($_SESSION['userId'])
            ->andReturn($userNumId);
        $commentMock = \Mockery::mock('overload:' . Comments::class);
        $commentMock
            ->shouldReceive('insertComment')
            ->with($userNumId, $params['comment'])
            ->andThrow(new \PDOException());
        $this->assertContains('エラーが発生しました', (string)$response->getBody());

    }
}
