<?php
namespace MyApp\model;

class User{
    private $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    /**
     * insert user data
     * @param {string} $userId
     * @param {string} $password
     * @param {string} $name
     */
    public function insertUser($userId, $password, $name){
        try{
            $stmt = $this->pdo->prepare('INSERT INTO users(user_id, password, name) VALUES(:user_id, :password, :name)');
            $stmt->bindValue(':user_id', $userId, \PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, \PDO::PARAM_STR);
            $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
            $stmt->execute();
        }catch(\PDOException $e){
            throw $e;
        }
    }

    /**
     * search user whose id is same as $userId
     * @param {string} $userId
     * @return {array} user
     */
    public function searchUserById($userId){
        try{
            $stmt = $this->pdo->prepare('SELECT user_id, password, name FROM users WHERE user_id = :user_id');
            $stmt->bindValue(':user_id', $userId, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(\PDOException $e){
            throw $e;
        }
    }
}
