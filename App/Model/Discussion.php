<?php

/**
 *  @title : Discussion.php
 * 
 *  @author Guillaume RISCH
 *  @author Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief : Discussion model
 *  
 */


class Discussion extends Model {

    protected $id;
    protected $travel_id;
    protected $id_creator;
    protected $id_passenger;
    protected $listMessages = [];



    /**
     *  @name : __construct
     * 
     *  @param int $id
     *  @param int $travel_id
     *  @param int $id_creator
     *  @param int $id_passenger
     *  @param array(Message) $listMessages
     * 
     */
    function __construct($id, $travel_id, $id_creator, $id_passenger, $listMessages) {
        $this->id = $id;
        $this->travel_id = $travel_id;
        $this->id_creator = $id_creator;
        $this->id_passenger = $id_passenger;
        $this->listMessages = $listMessages;

    }


    
    /**
     *  @name : getDiscussionById
     * 
     *  @param int $discussion_id
     * 
     *  @return false if discussion not exists, new Discussion instead
     * 
     */
    public static function getDiscussionById($discussion_id) {
        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT *
                              FROM `discussion`
                              WHERE `discussion`.`discuss_id` = ?');
        
        $stmt->execute(array($discussion_id));
        
        $result = $stmt->fetchAll();


        // if discussion not exists
        if (sizeof($result) == 0 ) {
            return false;
        }


        // get messages of the discuss
        $listMessages = Message::getDiscussionMessage($result[0]['discuss_id']);


        return new Discussion (
            $result[0]['discuss_id'],
            $result[0]['id_travel'],
            $result[0]['id_creator'],
            $result[0]['id_passenger'],
            $listMessages
        );


    }



    /**
     *  @name : getDiscussion
     *  
     *  @param : travel_id
     *  @param : passenger_id
     * 
     *  @return false if discussion not exist return false new Discussion instead
     *
     */
    public static function getDiscussion($travel_id, $passenger_id) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT *
                              FROM `discussion`
                              WHERE `discussion`.`id_travel` = ?
                              AND   `discussion`.`id_passenger` = ?');
        
        $stmt->execute(array($travel_id, $passenger_id));
        
        $result = $stmt->fetchAll();

        // if discussion not exists
        if (sizeof($result) == 0 ) {
            return false;
        }


        // get messages of the discuss
        $listMessages = Message::getDiscussionMessage($result[0]['discuss_id']);


        return new Discussion (
            $result[0]['discuss_id'],
            $result[0]['id_travel'],
            $result[0]['id_creator'],
            $result[0]['id_passenger'],
            $listMessages
        );

    } // public static function getDiscussion($travel_id, $passenger_id)



    /**
     * @name : createDiscussion
     *  
     * @param int user_id
     * @param int travel_id
     * 
     * @return Discussion
     * 
     */
    public static function createDiscussion($user_id, $travel_id, $travel_creator) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('INSERT INTO `discussion` (`discuss_id`, `id_creator`, `id_passenger`, `id_travel`)
                              VALUES (NULL, ?, ?, ?)');

        $stmt->execute(array($travel_creator, $user_id, $travel_id));



    } // public static function createDiscussion($user_id, $travel_id)




    /**
     *  @name : isUserInDiscussion
     * 
     *  @param int $user_id
     * 
     *  @return boolean
     * 
     */
    public static function isUserInDiscussion($user_id) {

        $DB = static::DBConnect();
        
        $stmt = $DB->prepare('SELECT *
                              FROM `discussion`
                              WHERE `discussion`.`id_creator` = ?
                                 OR `discussion`.`id_passenger` = ?
                             ');

        $stmt->execute(array($user_id, $user_id));
    
        $result = $stmt->fetchAll();
        
        if (sizeof($result) == 0) {
            return false;
        }
        return true;

    } // public static function isUserInDiscussion($user_id)




    /*
        GETTERS SETTERS
    */
    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getTravel_id(){
		return $this->travel_id;
	}

	public function setTravel_id($travel_id){
		$this->travel_id = $travel_id;
	}

	public function getId_creator(){
		return $this->id_creator;
	}

	public function setId_creator($id_creator){
		$this->id_creator = $id_creator;
	}

	public function getId_passenger(){
		return $this->id_passenger;
	}

	public function setId_passenger($id_passenger){
		$this->id_passenger = $id_passenger;
	}

	public function getListMessages(){
		return $this->listMessages;
	}

	public function setListMessages($listMessages){
		$this->listMessages = $listMessages;
	}
}



?>