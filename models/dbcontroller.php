<?php

/**
 * Created by PhpStorm.
 * User: rliu1
 * Date: 5/19/16
 * Time: 10:12 AM
 */
class DBController
{
    private $host = "139.52.147.134";
    private $user = "faersusr";
    private $password = "FAERSTEST@CR2015";
    private $database = "faersv04.15";

    private $conn = null;

    public function getConn()
    {
        return $this->conn;
    }

    function __construct() {
        $this->conn = $this->connectDB();
    }

    function __destruct() {
        $this->conn=null;
    }

    function connectDB() {
        try{
            $db=new PDO('mysql:host='.$this->host.';dbname='.$this->database.';charset=utf8',$this->user,$this->password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $db;
    }

}