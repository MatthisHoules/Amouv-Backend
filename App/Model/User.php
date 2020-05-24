<?php

/**
 *  @title : User.php
 *  
 *  @author : Théo MOUMDJIAN
 *  @author : Guillaume RISCH
 *  @refractor : Matthis HOULES
 *  
 *  @brief : User model
 */


class User extends Model {

    protected $mail;
    protected $lastname;
    protected $firstname;
    protected $profilePicture;
    protected $active;
    protected $id;


    /**
     *  @name : __construct
     *  
     *  @param : string : $mail 
     *  @param : string : $lastname 
     *  @param : string : $firstname  
     *  @param : string : $profilePicture : profilePicture name
     *  @param : int : active
     *  @param : id : int (11)
     * 
     *  @return : void
     * 
     *  @brief : create a new user
     */
    function __construct($mail, $lastname, $firstname, $profilePicture, $active, $id) {
        $this->mail = $mail;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->profilePicture = $profilePicture;
        $this->active = $active;
        $this->id = $id;

    }



    
    /**
     *  @name : isMailExist
     *  
     *  @param : string : $mail  : value to check
     * 
     *  @return : boolean true if mail exist, false instead
     * 
     *  @brief : check if $mail already exists in the database
     */
    public static function isMailExist($mail) {

        $DB = static::DBConnect();
        

        $stmt = $DB->prepare('SELECT * FROM `user` WHERE `email` = ?');
        $stmt->execute([$mail]);

        $response = $stmt->fetchAll();
        
        if (sizeof($response) == 0) {
            return false;
        }

        return new User (
            $response[0]['email'],
            $response[0]['lastname'],
            $response[0]['firstname'],
            $response[0]['profileImg'],
            $response[0]['active'],
            $response[0]['id']
        );

    } // public static function isMailExist($mail)



    /**
     *  @name : newUser
     * 
     *  @param : string : $mail 
     *  @param : string : $lastname 
     *  @param : string : $firstname 
     *  @param : string : $pwd : crypted password
     * 
     *  @return : User Id
     * 
     *  @brief : insert new user in database
     * 
     */
    public static function newUser($mail, $lastname, $firstname, $pwd) {
        $DB = static::DBConnect();

        $stmt = $DB->prepare('INSERT INTO `user` (`lastname`, `firstname`, `email`, `password`, `profileImg`) 
                              VALUES (?, ?, ?, ?, NULL)');

        $stmt->execute([$lastname, $firstname, $mail, $pwd]);

        return $DB->lastInsertId();

    } // public static function newUser($mail, $lastname, $firstname)





    /**
     *  @name : isUserExist
     * 
     *  @param : $mail : mail
     *  @param : $pwd : password non crypted
     *  
     *  @return : User object if exist, false instead
     *                
     *  @brief : check in database if a user exist (with password & email)
     * 
     */
    public static function isUserExist($mail, $password) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT * FROM `user` WHERE `email` = ?');
        $stmt->execute([$mail]);

        $result = $stmt->fetchAll();

        // Check if one user exist with a mail
        if (sizeof($result) == 0) {
            return false;
        }

        if(!password_verify($password, $result[0]['password'])) {
            return false;
        }

        return new User (
            $result[0]['email'],
            $result[0]['lastname'],
            $result[0]['firstname'],
            $result[0]['profileImg'],
            $result[0]['active'],
            $result[0]['id']

        );

    } //   public static function isUserExist($mail, $password)




    /**
     *  @name : activateAccount
     * 
     *  @param : userId
     *  
     *  @return : void
     * 
     *  @brief : active user accoung
     * 
     */ 
    public static function activateAccount($userId) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('UPDATE `user` 
                              SET `active` = 1 
                              WHERE `user`.`id` = ?');

        $stmt->execute([$userId]);

        return;

    } // public static function activateAccount($userId)



    /*
        getters setter
    */
    public function getId() {
        return $this->id;
    }
    
    public function getMail(){
		return $this->mail;
	}

	public function setMail($mail){
		$this->mail = $mail;
	}

	public function getLastname(){
		return $this->lastname;
	}

	public function setLastname($lastname){
		$this->lastname = $lastname;
	}

	public function getFirstname(){
		return $this->firstname;
	}

	public function setFirstname($firstname){
		$this->firstname = $firstname;
	}

	public function getProfilePicture(){
		return $this->profilePicture;
	}

	public function setProfilePicture($profilePicture){
		$this->profilePicture = $profilePicture;
	}

	public function getActive(){
		return $this->active;
	}

	public function setActive($active){
		$this->active = $active;
	}


    /**
     *  @name : setPassword
     *  
     *  @param : $newPassword : crypted password
     *  @param : $userId : int (11)
     * 
     *  @return : void
     * 
     *  @brief : change user password
     * 
     * 
     */
    public static function setPassword($newPassword, $userId) {
        $DB = static::DBConnect();

        $stmt = $DB->prepare('UPDATE `user` 
                              SET `password` = ? 
                              WHERE `user`.`id` = ?');

        $stmt->execute([$newPassword, $userId]);

        return;


    }

}

 ?>