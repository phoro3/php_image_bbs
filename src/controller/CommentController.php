<?php
namespace MyApp\controller;

use Slim\Http\UploadedFile;
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
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['img'];
        $directory = $this->container->uploaded_directory;

        if(!empty($comment) || $uploadedFile->getError() === UPLOAD_ERR_OK){
            try{
                $userModel = new User($this->container->db);
                //Get user num id from userId
                $userNumId = $userModel->searchUserNumIdById($_SESSION['userId']);
                //Upload Image
                if($uploadedFile->getError() === UPLOAD_ERR_OK){
                    $filename = $this->moveUploadedFile($directory, $uploadedFile);
                }

                //Insert Comment
                $commentModel = new Comments($this->container->db);
                $commentModel->insertComment($userNumId, $comment, $filename);
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

    private function moveUploadedFile($directory, UploadedFile $uploadedFile){
        //Get file extension
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        //Get file name
        $filename = time() . '.' . $extension;

        //Upload file
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        //Remove extension and return it
        $name = explode('.', $filename);
        return $name[0];
    }
}
