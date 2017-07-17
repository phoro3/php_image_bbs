<?php
use PHPUnit\Framework\TestCase;

class DbConnectTest extends TestCase{
    public function testConnect(){
        $filename = 'conf/ini/database.ini';
        $passwordFilename = 'conf/ini/password.ini';
        $connector = new MyApp\model\DbConnector();
        $pdo = $connector->connect($filename, $passwordFilename);

        $this->assertNotNull($pdo);
    }
}
