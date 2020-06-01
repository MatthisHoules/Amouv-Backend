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
    public static function getTravel($travelId) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT * 
                              FROM `travel`
                              JOIN `car` ON `travel`.`id_car` = `car`.`car_id`
                              JOIN `user` ON `user`.`id` = `travel`.`id_Creator`
                              WHERE `id` = ?
                            ');
        $stmt->execute([$travelId]);

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        }

        return new Travel (
            $result[0]['travel_id'],
            new User(
                        $result[0]['email'],
                        $result[0]['lastname'],
                        $result[0]['firstname'],
                        $result[0]['profileimg'],
                        1,
                        $result[0]['Id']
                    ),
            null,
            $result[0]['departure'],
            $result[0]['arrival'],
            $result[0]['seats'],
            $result[0]['smoking'],
            $result[0]['lugage']
            
        );

    
    }
    


    /**
     *  @name : searchTravels
     * 
     *  @param $cityStart start city
     *  @param $cityEnd end city
     *  @param $dateD date departure
     * 
     *  @return array
     */
    public static function searchTravels($cityStart, $cityEnd, $dateD) {


        $DB = static::DBConnect();

        $stmt = $DB->prepare("SELECT *
                              FROM `Travel`
                              JOIN `user` ON `id_creator` = `user`.`Id`
                              WHERE `departure` = ?
                              AND `arrival` = ?
                              AND 
                                (
                                    `date_dep` >= DATE_SUB(FROM_UNIXTIME(?), INTERVAL 12 HOUR)
                                    OR `date_dep` <= DATE_SUB(FROM_UNIXTIME(?), INTERVAL -12 HOUR)
                                )
                              ORDER BY ABS(date_dep - FROM_UNIXTIME(?))
                            ");
        $stmt->execute([$cityStart, $cityEnd, $dateD, $dateD, $dateD]);

        $result = $stmt->fetchAll();

        $listTravel = [];
        for($i = 0; $i < sizeof($result); ++$i) {
            array_push($listTravel, new Travel(
                $result[$i]['travel_id'],
                new User(
                            $result[$i]['email'],
                            $result[$i]['lastname'],
                            $result[$i]['firstname'],
                            $result[$i]['profileimg'],
                            1,
                            $result[$i]['Id']
                        ),
                null,
                $result[$i]['departure'],
                $result[$i]['arrival'],
                $result[$i]['seats'],
                $result[$i]['smoking'],
                $result[$i]['lugage']
            ));
        }

        return $listTravel;

    } // public static function searchTravels($cityStart, $cityEnd, $dateD)





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

	public function getCar(){
		return $this->car;
	}

}