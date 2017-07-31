<?php
namespace Tests\middleware;

use Slim\Http\Response;
use MyApp\middleware\LoginMiddleware;

class LoginMiddlewareTest extends \PHPUnit_Framework_TestCase{

    /**
     * Test for invoke method
     */
    public function testInvoke(){
        $middleware = new LoginMiddleware();
        $next = function($req, $res){
            return $res;
        };

        //When 'isLogin' is true
        $_SESSION['isLogin'] = true;
        $this->assertTrue($_SESSION['isLogin']);
        $response = new Response();
        $return = $middleware->__invoke(null, $response, $next);
        $this->assertTrue($_SESSION['isLogin']);
        $this->assertEquals($response, $return);

        //When 'isLogin' is false
        $_SESSION['isLogin'] = false;
        $this->assertFalse($_SESSION['isLogin']);
        $response = new Response();
        $return = $middleware->__invoke(null, $response, $next);
        $this->assertFalse($_SESSION['isLogin']);
        $this->assertEquals(302, $return->getStatusCode());
    }
}
