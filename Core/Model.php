<?php


/**
 *  @title : Router.php
 *  @author : Guillaume RISCH
 *  @author : Matthis HOULES
 * 
 *  @brief : Router class (initialize controller)
 */


require_once(__DIR__.'/Config.php');

abstract class Model {



    protected static function DBConnect() {
        $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';

        $database = new PDO($dsn, Config::DB_USER, Config::DB_PWD);

        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $database;

   
    }


}


?>