<?php
namespace MyApp\controller;
use \Interop\Container\ContainerInterface as ContainerInterface;

class RootController{
    protected $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function showComment($request, $response, $args){
        $args = array();
        try{
            //Fetch comment data
            $commentModel = new \MyApp\model\Comments($this->container->db);
            $comments = $commentModel->fetchAllComments();

            $args['comments'] = $comments;
            return $this->container->renderer->render($response, 'index.php', $args);
        }catch(\PDOException $e){
            $this->logger->addError($e->getMessage());
            $args['errorMessage'] = 'エラーが発生しました';
            return $this->container->renderer->render($response, 'error.php', $args);
        }
    }
}
