<?php
namespace MyApp\controller;
use \Interop\Container\ContainerInterface as ContainerInterface;

class Root{
    protected $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function showComment($request, $response, $args){
        $args = array();
        try{
            //Fetch comment data
            $commentModel = new \MyApp\model\Comments();
            $comments = $commentModel->fetchAllComments($this->app->db);

            $args['comments'] = $comments;
            $this->app->renderer->render($response, 'index.php', $args);
        }catch(\PDOException $e){
            $this->logger->addError($e->getMessage());
            $args['errorMessage'] = 'エラーが発生しました';
            $this->app->renderer->render($response, 'error.php', $args);
        }
    }
}
