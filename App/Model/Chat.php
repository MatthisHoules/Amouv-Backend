<?php

/**
 *  @title : Chat.php
 * 
 *  @author : Guillaume RISCH
 *  @author : Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief : Chat model
 * 
 */

class Chat extends Model{


    protected $message_id;
    protected $id_user;
    protected $message;
    protected $created_at;


    /**
     *  @name : __construct
     *  
     *  @param : message_id
     *  @param : id_user
     *  @param : message
     *  @param : created_at 
     *
     *  @brief : constructor class Model
     * 
     */
    function __construct($message_id, $id_user, $message, $created_at){

        $this->message_id = $message_id;
        $this->id_user = $id_user;
        $this->message = $message;
        $this->created_at = $created_at; 

    }

    public static function insertmsg($pseudo, $message){
        $DB = static::DBConnect();

        $insertionmsg = $DB->prepare('INSERT INTO
        message(id_user, message) VALUES(?, ?)');

        $insertionmsg->execute(array($pseudo,$message));

        return;
    }

    public static function getmsg($id){
        $DB = static::DBConnect();

        $Allmsg = $DB->query('SELECT * FROM message');

        $results = $Allmsg->fetchAll();

        return $results;

    }
    
}