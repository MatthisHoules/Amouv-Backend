<?php


/**
 *  @title : Passenger.php
 * 
 *  @author Guillaume RISCH
 *  @author Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief : Passenger model
 *  
 */


class Passenger extends User {


    /**
     *  @name : __construct
     * 
     *  @param string $mail
     *  @param string $lastname
     *  @param string $firstname
     *  @param string $profilePicture
     *  @param int $active
     *  @param int $id
     * 
     *  @return void
     * 
     */
    function __construct($mail, $lastname, $firstname, $profilePicture, $active, $id) {

        parent::__construct($mail, $lastname, $firstname, $profilePicture, $active, $id);

    } // function __construct($mail, $lastname, $firstname, $profilePicture, $active, $id)


    /**
     *  @name : isPassengerInTravel 
     *  
     *  @param int $user_id
     *  @param Travel $travel
     *  
     *  @return : bool, true if user already in travel, false instead
     */
    public static function isPassengerInTravel($user_id, $travel) {

        foreach ($travel->getListPassenger() as $key => $passenger) {
            if ($passenger->getId() == $user_id) {
                return true;
            }
        }
        return false;
        
    } // public static function isPassengerInTravel($user_id, $travel_id)



    /**
     * 
     *  @name : getTravelPassengers
     * 
     *  @param int $travel_id
     * 
     *  @return array(Passenger) with key : passenger_id 
     * 
     */
    public static function getTravelPassenger($travel_id) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT * 
                              FROM `passenger`
                              JOIN `user` ON `passenger`.`user_id` = `user`.`Id`
                              WHERE `passenger`.`id_travel` = ?
                              ');

        $stmt->execute(array($travel_id));

        $results = $stmt->fetchAll();

        $listPassenger = array();
        for ($i=0; $i < sizeof($results); $i++) { 
            
            $listPassenger[$results[$i]['passenger_id']] = new Passenger(
                $results[$i]['email'],
                $results[$i]['lastname'],
                $results[$i]['firstname'],
                $results[$i]['profileimg'],
                $results[$i]['active'],
                $results[$i]['Id']
            );

        }
        return $listPassenger;

    } // public static function getTravelPassenger($travel_id)



    /**
     *  
     *  @name : createPassenger
     * 
     *  @param int $user_id
     *  @param int $travel_id
     *  
     *  @return void 
     * 
     */
    public static function createPassenger($user_id, $travel_id) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('INSERT INTO `passenger` (`passenger_id`, `id_travel`, `user_id`) 
                              VALUES (NULL, ?, ?);
                             ');
        $stmt->execute(array($travel_id, $user_id));

    } // public static function createPassenger($user_id, $travel_id)



} // class Passenger extends Model



?>