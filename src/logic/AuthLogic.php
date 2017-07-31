<?php
namespace MyApp\logic;

class AuthLogic{

    /**
     * Return wheter user is login
     */
    public function isLogin($userModel, $userId, $password){
        try{
            $user = $userModel->searchUserById($userId)[0];
        }catch(\PDOException $e){
            throw $e;
        }

        if($user['password'] === $password){
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['isLogin'] = true;
            return true;
        }else{
            return false;
        }
    }
}
