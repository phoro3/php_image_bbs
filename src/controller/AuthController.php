<?php
namespace MyApp\controller;

use MyApp\model\User;

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

        try{
            $userModel = new User($this->container->db);
            $user = $userModel->searchUserById($userId)[0];

            var_dump($user);
            var_dump($password);
            if($user['password'] === $password){
                $_SESSION['userId'] = $user['userId'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['isLogin'] = true;
                return $response->withStatus(302)->withHeader('Location', '/');
            }else{
                $args['errorMessage'] = 'ユーザーIDまたはパスワードが違います';
                return $this->container->renderer->render($response, 'error.php', $args);
            }
        }catch(\PDOException $e){
            $args['errorMessage'] = 'エラーが発生しました';
            return $this->container->renderer->render($response, 'error.php', $args);
        }
    }

    /*
     * Logout
     */
    public function logout($request, $response, $args){
        if($_SESSION['isLogin']){
            $_SESSION['isLogin'] = false;
            return $response->withStatus(302)->withHeader('Location', '/login');
        }
    }
}
