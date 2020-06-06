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
    protected $creator;
    protected $passenger;
    protected $listMessages = [];



    /**
     *  @name : __construct
     * 
     *  @param int $id
     *  @param int $travel_id
     *  @param User $creator
     *  @param User $passenger
     *  @param array(Message) $listMessages
     * 
     */
    function __construct($id, $travel_id, $creator, $passenger, $listMessages) {
        $this->id = $id;
        $this->travel_id = $travel_id;
        $this->creator = $creator;
        $this->passenger = $passenger;
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

        $stmt = $DB->prepare('SELECT `discuss_id`,`id_creator`,`id_passenger`,`id_travel`,
                                `creator`.id cid, `creator`.firstname cfirstname, `creator`.lastname clastname, `creator`.email cemail, `creator`.profileImg cprofileimg, `creator`.active cactive,
                                `passenger`.id pid, `passenger`.firstname pfirstname, `passenger`.lastname plastname, `passenger`.email pemail, `passenger`.profileImg pprofileimg, `passenger`.active pactive
                                
                                FROM `discussion`
                                
                                JOIN `user` as `creator` ON `creator`.id = `discussion`.`id_creator`
                                JOIN `user` as `passenger` ON `passenger`.id = `discussion`.`id_creator`
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
            new User(
                $result[0]['cemail'],
                $result[0]['clastname'],
                $result[0]['cfirstname'],
                $result[0]['clastname'],
                $result[0]['cprofileimg'],
                $result[0]['cid']
            ),
            new User(
                $result[0]['pemail'],
                $result[0]['plastname'],
                $result[0]['pfirstname'],
                $result[0]['plastname'],
                $result[0]['pprofileimg'],
                $result[0]['pid']
            ),
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

        $stmt = $DB->prepare('SELECT `discuss_id`,`id_creator`,`id_passenger`,`id_travel`,
                                `creator`.id cid, `creator`.firstname cfirstname, `creator`.lastname clastname, `creator`.email cemail, `creator`.profileImg cprofileimg, `creator`.active cactive,
                                `passenger`.id pid, `passenger`.firstname pfirstname, `passenger`.lastname plastname, `passenger`.email pemail, `passenger`.profileImg pprofileimg, `passenger`.active pactive
                                
                                FROM `discussion`
                                
                                JOIN `user` as `creator` ON `creator`.id = `discussion`.`id_creator`
                                JOIN `user` as `passenger` ON `passenger`.id = `discussion`.`id_creator`
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
            new User(
                $result[0]['cemail'],
                $result[0]['clastname'],
                $result[0]['cfirstname'],
                $result[0]['clastname'],
                $result[0]['cprofilepicture'],
                $result[0]['cid']
            ),
            new User(
                $result[0]['pemail'],
                $result[0]['plastname'],
                $result[0]['pfirstname'],
                $result[0]['plastname'],
                $result[0]['pprofilepicture'],
                $result[0]['pid']
            ),
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



    /**
     *  @name : getOtherId
     * 
     *  @param int $user_id : session user id
     * 
     *  @return int the other id in the discussion
     * 
     */
    public function getOtherId($user_id) {

        if ($user_id == $this->getCreator()->getId()) {
            return $this->getPassenger()->getId();
        } 
        return $this->getCreator()->getId();
        

    } // public function getOtherId($user_id)



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

	public function getCreator(){
		return $this->creator;
	}


	public function getPassenger(){
		return $this->passenger;
	}



	public function getListMessages(){
		return $this->listMessages;
	}

	public function setListMessages($listMessages){
		$this->listMessages = $listMessages;
	}
}



?>