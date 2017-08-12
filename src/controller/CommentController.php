<?php
namespace MyApp\controller;

use MyApp\model\User;
use MyApp\model\Comments;

class CommentController{
    protected $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function addComment($request, $response, $args){
        $params = $request->getParsedBody();
        $comment = $params['comment'];

        if($comment){
            try{
                $userModel = new User($this->container->db);
                //Get user num id from userId
                $userNumId = $userModel->searchUserNumIdById($_SESSION['userId']);
                //Insert Comment
                $commentModel = new Comments($this->container->db);
                $commentModel->insertComment($userNumId, $comment);
            }catch(\PDOException $e){
                $args['errorMessage'] = 'エラーが発生しました';
                return $this->container->renderer->render($response, 'error.php', $args);
            }
        }else{
            //If post data is null
            $_SESSION['errorMessage'] = '何も入力されていません';
        }

        return $response->withStatus(302)->withHeader('Location', '/');
    }
}
