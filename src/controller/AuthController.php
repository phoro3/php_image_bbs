<?php
namespace MyApp\controller;

use MyApp\model\User;
use MyApp\logic\AuthLogic;

class AuthController{
    protected $container;

    public function __construct($container){
        $this->container = $container;
    }

    /**
     * Login
     */
    public function login($request, $response, $args){
        $params = $request->getParsedBody();
        $userId = $params['userId'];
        $password = $params['password'];

        if($userId and $password){
            try{
                $userModel = new User($this->container->db);
                $auth = new AuthLogic();

                if($auth->isLogin($userModel, $userId, $password)){
                    return $response->withStatus(302)->withHeader('Location', '/');
                }else{
                    $args['errorMessage'] = 'ユーザーIDまたはパスワードが違います';
                    return $this->container->renderer->render($response, 'login.php', $args);
                }
            }catch(\PDOException $e){
                $args['errorMessage'] = 'エラーが発生しました';
                return $this->container->renderer->render($response, 'error.php', $args);
            }
        }else{
            $args['errorMessage'] = 'ユーザーIDとパスワードの両方を入力してください';
            return $this->container->renderer->render($response, 'login.php', $args);
        }
    }

    /*
     * Logout
     */
    public function logout($request, $response, $args){
        if($_SESSION['isLogin']){
            $_SESSION['isLogin'] = false;
            return $response->withStatus(302)->withHeader('Location', '/login');
        }else{
            $args['errorMessage'] = 'エラーが発生しました';
            return $this->container->renderer->render($response, 'error.php', $args);
        }
    }
}
