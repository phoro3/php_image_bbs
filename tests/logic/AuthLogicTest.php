<?php
namespace Tests\logic;

use MyApp\logic\AuthLogic;
use MyApp\model\User;

class AuthLogicTest extends \PHPUnit_Framework_TestCase{

    /**
     * Test for isLogin
     */
    public function testIsLogin(){
        $logic = new AuthLogic();

        $userData = array(
            array(
                'userId' => 'test',
                'password' => 'testpassword',
                'name' => 'testname'
            )
        );

        //Test data
        $userId = 'test';
        $password = 'testpassword';
        //Create mock
        $userMock = \Mockery::mock('User');
        $userMock
            ->shouldReceive('searchUserById')
            ->with($userId)
            ->andReturn($userData);

        //When password is correct
        $return = $logic->isLogin($userMock, $userId, $password);
        $this->assertTrue($return);
        $this->assertEquals($userData[0]['userId'], $_SESSION['userId']);
        $this->assertEquals($userData[0]['name'], $_SESSION['name']);
        $this->assertTrue($_SESSION['isLogin']);

        //When password is incorrect
        $_SESSION['userId'] = null;
        $_SESSION['name'] = null;
        $_SESSION['isLogin'] = null;
        $this->assertNull($_SESSION['userId']);
        $this->assertNull($_SESSION['name']);
        $this->assertNull($_SESSION['isLogin']);
        $return = $logic->isLogin($userMock, $userId, 'incorrectpassword');
        $this->assertFalse($return);
        $this->assertNull($_SESSION['userId']);
        $this->assertNull($_SESSION['name']);
        $this->assertNull($_SESSION['isLogin']);
    }

    /**
     * Test for isLogin when exception happens
     */
    public function testIsLoginWithException(){
        $logic = new AuthLogic();

        //Test data
        $userId = 'test';
        $password = 'testpassword';

        //Create mock
        $userMock = \Mockery::mock('User');
        $userMock
            ->shouldReceive('searchUserById')
            ->andThrow(new \PDOException());

        try{
            $result = $logic->isLogin($userMock, $userId, $password);
            $this->fail();
        }catch(\PDOException $e){
            $this->assertNotNull($e);
        }
    }
}
