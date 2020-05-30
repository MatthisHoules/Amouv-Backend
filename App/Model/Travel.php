<?php

/**
 *  @title : travel.php
 * 
 *  @author Guillaume RISCH
 *  @author Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief : Travel model
 *  
 */

class Travel extends Model {


    protected $id;
    protected $user;
    protected $car;
    protected $departure;
    protected $arrival;
    protected $seats;
    protected $smoking;
    protected $lugage;


    /**
     *  @name : __construct
     * 
     *  @param : id
     *  @param : user
     *  @param : car
     *  @param : departure
     *  @param : arrival
     *  @param : seats
     *  @param : smoking
     *  @param : lugage
     *  
     *  @return : Travel
     */
    function __construct($id, $user, $car, $departure, $arrival, $seats, $smoking, $lugage) {

        $this->id = $id;
        $this->user = $user;
        $this->car = $car;
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->seats = $seats;
        $this->smoking = $smoking;
        $this->lugage = $lugage;



    } // function __construct($id, $user, $car, $departure, $arrival, $seats, $smoking, $lugage)


    /**
     *  @name : insertNewTravel
     *  
     *  @param : id_car : int
     *  @param : departure : varchar
     *  @param : arrival : varchar
     *  @param : seats : int
     *  @param : smoking : boolean
     *  @param : lugage : int
     * 
     *  @return : void
     * 
     *  @brief : insert in database a new car
     * 
     */
    public static function insertNewTravel($id_car, $departure, $arrival, $date_dep, $seats, $smoking, $lugage) {
        $DB = static::DBConnect();
        
        $stmt = $DB->prepare('INSERT INTO `travel` (
                                                    `id_Creator`, 
                                                    `id_car`, 
                                                    `date_dep`, 
                                                    `departure`, 
                                                    `arrival`, 
                                                    `seats`, 
                                                    `smoking`, 
                                                    `lugage`, 
                                                    `active`) 
                               VALUES (?, ?, FROM_UNIXTIME(?), ?, ?, ?, ?, ?, \'1\')');

        $stmt->execute([$_SESSION['user']->getId(), 
                        $id_car,
                        $date_dep,
                        $departure,
                        $arrival,
                        $seats,
                        $smoking,
                        $lugage
        ]);

        return;

    }
    

    /**
     * 
     *  @name : getTravel
     * 
     *  @param : travelId : int 
     * 
     *  @return : Travel object if travel exist, false instead
     *              
     *  @brief : get a travel if it exist
     * 
     */
    public function getTravel($travelId) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT * 
                              FROM `travel`
                              JOIN `car` ON `travel.id_car` = `car.id`
                              JOIN `user` ON `user.id` = `travel.id_Creator`
                              WHERE `id` = ?
                            ');
        $stmt->execute([$travelId]);

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        }

        return new Travel (
            
        );

        


    }
    



}