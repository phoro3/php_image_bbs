<?php
namespace MyApp\model;

class Comments{
    private $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    /**
     * fetch all comments which are not deleted
     * @return {array} comments
     */
    public function fetchAllComments(){
        try{
            $stmt = $this->pdo->prepare('SELECT * FROM comments WHERE delete_flag = 0');
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(\PDOException $e){
            throw $e;
        }
    }

    /**
     * Insert comment
     * @param {integer} $userNumId
     * @param {string} $comment
     */
    public function insertComment($userNumId, $comment){
        try{
            $stmt = $this->pdo->prepare('INSERT INTO comments(user_id, comment) VALUES(:user_id, :comment)');
            $stmt->bindValue(':user_id', $userNumId, \PDO::PARAM_INT);
            $stmt->bindValue(':comment', $comment, \PDO::PARAM_STR);
            $stmt->execute();
        }catch(\PDOException $e){
            throw $e;
        }
    }
}
