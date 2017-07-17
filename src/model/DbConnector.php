<?php
namespace MyApp\model;

class DbConnector{
    public function connect($filename, $passwordFilename){
        $settings = parse_ini_file($filename);
        $password = parse_ini_file($passwordFilename);

        if($settings and $password){
            try{
                $dsn = $settings['dsn'];
                $user = $settings['user'];
                $pass = $password['password'];
                $option = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_EMULATE_PREPARES => false);
                $pdo = new \PDO($dsn, $user, $pass, $option);

                return $pdo;
            }catch(\PDOException $e){
                throw $e;
            }
        }else{
            return null;
        }
    }
}
