<?php
namespace MyApp\controller;
use \Interop\Container\ContainerInterface as ContainerInterface;

class Root{
    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    public function showComment($request, $response, $args){
        $args = array();
        try{
            //Connect DB
            $filename = __DIR__ . '/../../conf/ini/database.ini';
            $passwordFilename = __DIR__ . '/../../conf/ini/password.ini';
            $connector = new \MyApp\model\DbConnector();
            $pdo = $connector->connect($filename, $passwordFilename);

            //Fetch comment data
            $commentModel = new \MyApp\model\Comments();
            $comments = $commentModel->fetchAllComments($pdo);

            $args['comments'] = $comments;
            $this->container['renderer']->render($response, 'index.php', $args);
        }catch(\PDOException $e){
            $this->container['logger']->addError($e->getMessage());
            $args['errorMessage'] = 'エラーが発生しました';
            $this->container['renderer']->render($response, 'error.php', $args);
        }
    }
}
