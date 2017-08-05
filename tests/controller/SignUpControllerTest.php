<?php
namespace Tests\controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Tests\controller\BaseClass;
use MyApp\controller\SignUpController;
use MyApp\model\User;
use MyApp\model\Comments;

class SignUpControllerTest extends BaseClass{

    /**
     * Test for addUser with normal case
     */
    public function testAddUser(){
        $controller = new SignUpController($this->container);
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/signup/add'
            ]
        );

        //Prepare request parameters
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'test',
            'password' => 'test',
            'name' => 'test'
        );
        $request = $request->withParsedBody($params);

        $comments = array(
            array('comment' => 'test comment')
        );
        //Create mocks
        $userMock = \Mockery::mock('overload:' . User::class);
        $userMock
            ->shouldReceive('searchUserById')
            ->with($params['userId']);
        $userMock
            ->shouldReceive('insertUser')
            ->with($params['userId'], $params['password'], $params['name']);
        $response = $controller->addUser($request, new Response(), null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Test for addUser when invalid inputs are given
     */
    public function testAddUserWithInvalidInput(){
        $controller = new SignUpController($this->container);
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/signup/add'
            ]
        );

        //When one of parameters is empty
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => '',
            'password' => '',
            'name' => 'test'
        );
        $request = $request->withParsedBody($params);
        $response = $controller->addUser($request, new Response(), null);
        $this->assertContains('全ての項目を入力してください', (string)$response->getBody(), 'fail at null check');

        //When ID is not only from alphabets
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'テスト',
            'password' => 'test',
            'name' => 'test'
        );
        $request = $request->withParsedBody($params);
        $response = $controller->addUser($request, new Response(), null);
        $this->assertContains('IDは英数字で入力してください', (string)$response->getBody(), 'fail at id character assert');

        //When userId length is over 20
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'aaaaaaaaaaaaaaaaaaaaa',
            'password' => 'test',
            'name' => 'test'
        );
        $request = $request->withParsedBody($params);
        $response = $controller->addUser($request, new Response(), null);
        $this->assertContains('IDは20文字以内で入力してください', (string)$response->getBody(), 'fail at id length');

        //When password length is over 20
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'test',
            'password' => 'aaaaaaaaaaaaaaaaaaaaa',
            'name' => 'test'
        );
        $request = $request->withParsedBody($params);
        $response = $controller->addUser($request, new Response(), null);
        $this->assertContains('パスワードは20文字以内で入力してください', (string)$response->getBody(), 'fail at password length');

        //When name length is over 20
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'test',
            'password' => 'test',
            'name' => 'aaaaaaaaaaaaaaaaaaaaa'
        );
        $request = $request->withParsedBody($params);
        $response = $controller->addUser($request, new Response(), null);
        $this->assertContains('ニックネームは20文字以内で入力してください', (string)$response->getBody(), 'fail at nickname length');

        //When name already exists
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'test',
            'password' => 'test',
            'name' => 'testuser'
        );
        $request = $request->withParsedBody($params);

        //Create Mock
        $userMock = \Mockery::mock('overload:' . User::class);
        $userMock
            ->shouldReceive('searchUserById')
            ->with($params['userId'])
            ->andReturn(array(1));
        $response = $controller->addUser($request, new Response(), null);
        $this->assertContains('IDが重複しています', (string)$response->getBody(), 'fail at nickname which already exists');
    }

    /**
     * Test addUser when exception happens
     */
    public function testAddUserWithException(){
        $controller = new SignUpController($this->container);
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/signup/add'
            ]
        );

        //Exception at serachUserByName
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'test',
            'password' => 'test',
            'name' => 'test'
        );
        $request = $request->withParsedBody($params);
        $userMock = \Mockery::mock('overload:' . User::class);
        $userMock
            ->shouldReceive('searchUserById')
            ->with($params['userId'])
            ->andThrow(new \PDOException(''));
        $response = $controller->addUser($request, new Response(), null);
        $this->assertContains('エラーが発生しました', (string)$response->getBody(), 'fail at exception test');
        \Mockery::close();

        //Exception at insertUser
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'test',
            'password' => 'test',
            'name' => 'test'
        );
        $request = $request->withParsedBody($params);
        $userMock = \Mockery::mock('overload:' . User::class);
        $userMock
            ->shouldReceive('searchUserById')
            ->with($params['userId']);
        $userMock
            ->shouldReceive('insertUser')
            ->with($params['userId'], $params['password'], $params['name'])
            ->andThrow(new \PDOException());
        $response = $controller->addUser($request, new Response(), null);
        $this->assertContains('エラーが発生しました', (string)$response->getBody(), 'fail at exception test');
        \Mockery::close();
    }
}
