<?php
namespace Tests\controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Tests\controller\BaseClass;
use MyApp\model\User;
use MyApp\controller\AuthController;
use MyApp\logic\AuthLogic;

class AuthControllerTest extends BaseClass{

    /**
     * Test for login with normal case
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLogin(){
        $controller = new AuthController($this->container);
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/login/auth'
            ]
        );

        //Prepare request parameters
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'test',
            'password' => 'test',
        );
        $request = $request->withParsedBody($params);

        //Create Mock
        $authMock = \Mockery::mock('overload:' . AuthLogic::class);
        $authMock
            ->shouldReceive('isLogin')
            ->andReturn(true);
        $response = $controller->login($request, new Response(), null);
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Test for login when invalid inputs are given
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLoginWithInvalidArgument(){
        $controller = new AuthController($this->container);
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/login/auth'
            ]
        );

        //When parameter is null
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => '',
            'password' => 'test',
        );
        $request = $request->withParsedBody($params);
        $response = $controller->login($request, new Response(), null);
        $this->assertContains('ユーザーIDとパスワードの両方を入力してください', (string)$response->getBody());


        //When id and password are not correct
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'test',
            'password' => 'test',
        );
        $request = $request->withParsedBody($params);
        //Create Mock
        $authMock = \Mockery::mock('overload:' . AuthLogic::class);
        $authMock
            ->shouldReceive('isLogin')
            ->andReturn(false);
        $response = $controller->login($request, new Response(), null);
        $this->assertContains('ユーザーIDまたはパスワードが違います', (string)$response->getBody());
    }

    /**
     * Test for login when excepiton happens
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLoginWithException(){
        $controller = new AuthController($this->container);
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/login/auth'
            ]
        );

        //Prepare request parameters
        $request = Request::createFromEnvironment($environment);
        $params = array(
            'userId' => 'test',
            'password' => 'test',
        );
        $request = $request->withParsedBody($params);

        //Create Mock
        $authMock = \Mockery::mock('overload:' . AuthLogic::class);
        $authMock
            ->shouldReceive('isLogin')
            ->andThrow(new \PDOException());
        $response = $controller->login($request, new Response(), null);
        $this->assertContains('エラーが発生しました', (string)$response->getBody());
    }

    /**
     * Test for logout
     */
    public function testLogout(){
        $controller = new AuthController($this->container);
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' =>'POST', 
                'REQUEST_URI' => '/logout'
            ]
        );
        $request = Request::createFromEnvironment($environment);

        //When 'isLogin' is true
        $_SESSION['isLogin'] = true;
        $this->assertTrue($_SESSION['isLogin']);
        $response = $controller->logout($request, new Response(), null);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertFalse($_SESSION['isLogin']);

        //When 'isLogin' is false
        $_SESSION['isLogin'] = false;
        $this->assertFalse($_SESSION['isLogin']);
        $response = $controller->logout($request, new Response(), null);
        $this->assertFalse($_SESSION['isLogin']);
        $this->assertContains('エラーが発生しました', (string)$response->getBody());
    }
}
