<?php
/**
 * Created by PhpStorm.
 * User: Diana Öller
 * Date: 02.06.2018
 * Time: 09:35
 */

class DB{
    private $servername="wi-projectdb.technikum-wien.at";
    private $user="s18-bvz2-fst-32";
    private $pwd="DbPass4v032";
    private $dbname="s18-bvz2-fst-30";
    private $dbobject = null;

    function doConnect(){
        $this->dbobject = new mysqli($this->servername,$this->user,$this->pwd,$this->dbname);
        if($this->dbobject->connect_error){
            echo "Connection failed: ".$this->dbobject->connect_error;
        }else{
            echo "Connected succesfully";
        }
    }





}