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
            $stmt = $this->pdo->prepare('SELECT c.comment, u.name, c.image_path 
                FROM comments AS c
                JOIN users AS u
                ON c.user_id = u.id
                WHERE c.delete_flag = 0');
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
    public function insertComment($userNumId, $comment, $filename){
        try{
            $stmt = $this->pdo->prepare('INSERT INTO comments(user_id, comment, image_path) VALUES(:user_id, :comment, :filename)');
            $stmt->bindValue(':user_id', $userNumId, \PDO::PARAM_INT);
            $stmt->bindValue(':comment', $comment, \PDO::PARAM_STR);
            $stmt->bindValue(':filename', $filename, \PDO::PARAM_STR);
            $stmt->execute();
        }catch(\PDOException $e){
            throw $e;
        }
    }
}
