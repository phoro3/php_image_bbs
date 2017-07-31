<?php
namespace MyApp\middleware;

class LoginMiddleware{
    public function __invoke($request, $response, $next){
        if($_SESSION['isLogin']){
            $response = $next($request, $response);
            return $response;
        }else{
            return $response->withStatus(302)->withHeader('Location', '/login');
        }
    }
}
