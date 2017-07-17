<?php
namespace MyApp\model;

class Comments{
    public function fetchAllComments($pdo){
        try{
            $stmt = $pdo->prepare('SELECT * FROM comments WHERE delete_flag = 0');
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(\PDOException $e){
            throw $e;
        }
    }
}
