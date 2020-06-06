<?php

/**
 *  @title : Message.php
 * 
 *  @author Guillaume RISCH
 *  @author Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief : Message model
 *  
 */

class Message extends Model {

    protected $id;
    protected $discussion_id;
    protected $user;
    protected $message;
    protected $created_at;




    /**
     *  @name : __construct
     * 
     *  @param int $id
     *  @param User $user
     *  @param string $message  
     *  @param string $created_at
     * 
     */
    function __construct($id, $discussion_id,  $user, $message, $created_at) {
        $this->id = $id;
        $this->discussion_id = $discussion_id;
        $this->user = $user;
        $this->message = $message;
        $this->created_at = $created_at;
    
    } // function __construct($id, $user_id, $message, $created_at)




    /**
     *  @name : getDiscussionMessages
     * 
     *  @param int discussion_id
     * 
     *  @return array(Message)
     * 
     */
    public static function getDiscussionMessage($discussion_id) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT * 
                              FROM `message`
                              JOIN `user` ON `message`.`id_user` = `user`.`Id`
                              WHERE `discussion_id` = ?
                              ORDER BY `message`.`created_at` ASC
                             ');    

        $stmt->execute(array($discussion_id));
            
        $result = $stmt->fetchAll();


        $listMessage = [];
        for ($i=0; $i < sizeof($result) ; $i++) { 

            $listMessage[$i] = new Message($result[$i]['message_id'],
                                           $result[$i]['discussion_id'],
                                           new User($result[$i]['email'],
                                                    $result[$i]['lastname'],
                                                    $result[$i]['firstname'],
                                                    $result[$i]['profileimg'],
                                                    $result[$i]['active'],
                                                    $result[$i]['Id']),
                                           $result[$i]['message'],
                                           $result[$i]['created_at']
                                          );


        }

        return $listMessage;


    } // public static function getDiscussionMessage($discussion_id)




    /**
     *  @name insertMsg
     *  
     *  @param int discussion_id
     *  @param string message
     *  @param int user_id
     * 
     *  @return void
     * 
     */
    public static function insertMsg($discussion_id, $message, $user_id) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('INSERT INTO `message` (`message_id`, `discussion_id`, `id_user`, `message`, `created_at`) 
                              VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP)');

        $stmt->execute(array($discussion_id, $user_id, $message));

        return;

    } // public static function insertMsg($message, $user_id)




    /*
        GETTERS & SETTERS
    */
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getUser(){
		return $this->user;
	}

	public function setUser($user){
		$this->user = $user;
	}

	public function getMessage(){
		return $this->message;
	}

	public function setMessage($message){
		$this->message = $message;
	}

	public function getCreated_at(){
		return $this->created_at;
	}

	public function setCreated_at($created_at){
		$this->created_at = $created_at;
	}


}



?>