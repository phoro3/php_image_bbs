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
}
