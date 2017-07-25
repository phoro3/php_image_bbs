<?php
namespace MyApp\controller;

use MyApp\model\User;

class SignUpController{
    protected $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function addUser($request, $response, $args){
        $userId = filter_input(INPUT_POST, 'user_id');
        $password = filter_input(INPUT_POST, 'password');
        $name = filter_input(INPUT_POST, 'name');

        if(!($userId and $password and $name)){
            $args['errorMessage'] = '全ての項目を入力してください';
            return $this->container->renderer->render($response, 'signup.php', $args);
        }else if(!ctype_alnum($userId)){
            $args['errorMessage'] = 'IDは英数字で入力してください';
            return $this->container->renderer->render($response, 'signup.php', $args);
        }else if(mb_strlen($userId) > 20){
            $args['errorMessage'] = 'IDは20文字以内で入力してください';
            return $this->container->renderer->render($response, 'signup.php', $args);
        }else if(mb_strlen($password) > 20){
            $args['errorMessage'] = 'パスワードは20文字以内で入力してください';
            return $this->container->renderer->render($response, 'signup.php', $args);
        }else if(mb_strlen($name) > 20){
            $args['errorMessage'] = 'ニックネームは20文字以内で入力してください';
            return $this->container->renderer->render($response, 'signup.php', $args);
        }else{
            try{
                $userModel = new User($this->container->db);

                $sameNameUser = $userModel->searchUserByName($userId);
                if(count($sameNameUser) > 0){
                    //When userId exists
                    $args['errorMessage'] = 'IDが重複しています';
                    return $this->container->renderer->render($response, 'signup.php', $args);
                }else{
                    $userModel->insertUser($userId, $password, $name);

                    $commentModel = new \MyApp\model\Comments($this->container->db);
                    $comments = $commentModel->fetchAllComments();

                    $args['comments'] = $comments;
                    return $this->container->renderer->render($response, 'index.php', $args);
                }
            }catch(\PDOException $e){
                $args['errorMessage'] = 'エラーが発生しました';
                return $this->container->renderer->render($response, 'error.php', $args);
            }
        }
    }
}
