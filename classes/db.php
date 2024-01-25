<?php
$db = new Db;
class Db{

    public function connect(){

    try{
        $conn = new PDO("mysql:localhost=db;dbname=blog_23", 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->conn = $conn;

    }catch(PDOException $e){
        die($e->getMessage());
    }
}
}
?>