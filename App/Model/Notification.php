<?php

/**
 *  @title : Notification.php
 * 
 *  @author Guillaume RISCH
 *  @author Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief : Notification model
 *  
 */
class Notification extends Model {

    protected $id;
    protected $message;
    protected $link;
    protected $created_at;
    protected $active;

    

    /**
     *  
     * @name : __construct
     * 
     *  @param int $id
     *  @param string $message
     *  @param string $link
     *  @param string created_at
     *  @param int active
     * 
     *  @return void
     * 
     */
    function __construct($id, $message, $link, $created_at, $active) {
        
        $this->id = $id;
        $this->message = $message;
        $this->link = $link;
        $this->created_at = $created_at;
        $this->active = $active;

    } // function __construct($id, $user, $message, $link, $created_at, $active)




    /**
     * 
     *  @name : getListNotification
     * 
     *  @param int $user_id
     * 
     *  @return array(Notification) with key notification_id 
     * 
     */
    public static function getListNotification($user_id) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT * 
                              FROM `notification`
                              WHERE `notification`.`id_user` = ?
                              ORDER BY `notification`.`created_at` DESC
                              LIMIT 10
                             ');
        $stmt->execute(array($user_id));

        $results = $stmt->fetchAll();

        $listNotification = array();
        for ($i=0; $i < sizeof($results) ; $i++) { 
            $listNotification[$results[$i]['notification_id']] = new Notification (
                $results[$i]['notification_id'],
                $results[$i]['message'],
                $results[$i]['link'],
                $results[$i]['created_at'],
                $results[$i]['active']
            );
        }

        return $listNotification;

    } // public static function getListNotification($user_id)




    /**
     *  
     *  @name : getNotification
     * 
     *  @param int $notification_id
     * 
     *  @return Notification if exist, false instead
     * 
     */
    public static function getNotification($notification_id) {
        $DB = static::DBConnect();

        $stmt = $DB->prepare('  SELECT * 
                                FROM `notification`
                                WHERE `notification`.`notification_id` = ?');

        $stmt->execute(array($notification_id));

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        }

        return new Notification (
            $result[0]['notification_id'],
            $result[0]['message'],
            $result[0]['link'],
            $result[0]['created_at'],
            $result[0]['active']
        );
        
    } //  public static function getNotification($notification_id)



    /**
     *  
     *  @name : createNotification
     *  
     *  @param int $user_id
     *  @param string $message
     *  @param string $link
     * 
     *  @return void 
     */
    public static function createNotification ($user_id, $message, $link) {
        $DB = static::DBConnect();

        $stmt = $DB->prepare('INSERT INTO `notification` (`notification_id`, `id_user`, `message`, `link`, `created_at`, `active`) 
                              VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP, \'1\')
                             ');
        $stmt->execute([
            $user_id,
            $message, 
            $link        
        ]);

        return;

    } // public static function createNotification ($user_id, $message, $link, $created_at, $active)





    /**
     *  @name notificationBelongsToUser
     *  
     *  @param User : $user
     * 
     *  @return bool : true if notification belong to the User, false instead
     */
    public function notificationBelongsToUser($user) {

        $listNotificationUser = array_keys($user->getNotification());

        if (in_array($this->getId(), $listNotificationUser)){
            return true;
        }
        return false;

    } // public function notificationBelongToUser($user)



    /**
     * 
     *  @name : notificationUserNotRead
     * 
     *  @param : User $user
     * 
     *  @return bool if there are notification not read true, false instead
     * 
     */
    public static function notificationUserNotRead($user) {

        foreach ($user->getNotification() as $id => $notification) {

            // if notification not read
            if ($notification->getActive() == 1) {
                return true;
            }
        }
        return false;

    } // public static function notificationUserNotRead($user)




    /*
        getters setters
    */
    public function getId() {
        return $this->id;
        
	} // public function getId()

	public function setId($id) {
        $this->id = $id;
        
	} // public function setId($id)

	public function getUser() {
        return $this->user;
        
	} // public function getUser()

	public function setUser($user) {
        $this->user = $user;
        
	} // public function setUser($user)

	public function getMessage() {
        return $this->message;
        
	} // public function getMessage()

    public function getActive() {
        return $this->active;
        
    } // public function getActive()
    
    public function setActive($active) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('UPDATE `notification` SET `active` = ? WHERE `notification`.`notification_id` = ?');
        
        $stmt->execute(array($active, $this->getId()));

        $this->active = $active;

        return;
	} // public function setActive($active)

    public function getCreated_at(){
		return $this->created_at;
	}

	public function setCreated_at($created_at){
		$this->created_at = $created_at;
    }
    
    public function getLink(){
		return $this->link;
	}

	public function setLink($link){
		$this->link = $link;
	}

} // class Notification 






?>