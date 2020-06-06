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
    protected $dateDeparture;
    protected $listPassenger = [];


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
    function __construct($id, $user, $car, $departure, $arrival, $seats, $smoking, $lugage, $dateDeparture) {

        $this->id = $id;
        $this->user = $user;
        $this->car = $car;
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->seats = $seats;
        $this->smoking = $smoking;
        $this->lugage = $lugage;
        $this->dateDeparture = $dateDeparture;

        $this->listPassenger = Passenger::getTravelPassenger($this->getId());


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
                        1,
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
                              WHERE `travel_id` = ?
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
            new Car (
                        $result[0]['car_id'],
                        $result[0]['color'],
                        $result[0]['car_seat'],
                        $result[0]['model'],
                        $result[0]['motorization']
                        
                    ),
            $result[0]['departure'],
            $result[0]['arrival'],
            $result[0]['seats'],
            $result[0]['smoking'],
            $result[0]['lugage'],
            $result[0]['date_dep']
            
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
                              ORDER BY ABS(FROM_UNIXTIME(?) - date_dep) desc
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
                $result[$i]['lugage'],
                $result[$i]['date_dep']

            ));
        }

        return $listTravel;

    } // public static function searchTravels($cityStart, $cityEnd, $dateD)



    
    /**
     *  @name : getTravelPassenger
     *  
     *  @param int travelId
     * 
     *  @return array(User)
     * 
     */
    public static function getCountTravelPassenger($travelId) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT COUNT(*) as NBPassenger
                              FROM `passenger`
                              WHERE `passenger`.`id_travel` = ?
                              ');
        
        $stmt->execute(array($travelId));

        $result = $stmt->fetchAll();
        
        return $result;


    } // public static function getCountTravelPassenger($travelId)



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

	public function setCar($car){
		$this->car = $car;
	}

	public function getDeparture(){
		return $this->departure;
	}

	public function setDeparture($departure){
		$this->departure = $departure;
	}

	public function getArrival(){
		return $this->arrival;
	}

	public function setArrival($arrival){
		$this->arrival = $arrival;
	}

	public function getSeats(){
		return $this->seats;
	}

	public function setSeats($seats){
		$this->seats = $seats;
	}

	public function getSmoking(){
		return $this->smoking;
	}

	public function setSmoking($smoking){
		$this->smoking = $smoking;
	}

	public function getLugage(){
		return $this->lugage;
	}

	public function setLugage($lugage){
		$this->lugage = $lugage;
	}

	public function getDateDeparture(){
		return $this->dateDeparture;
	}

	public function setDateDeparture($dateDeparture){
		$this->dateDeparture = $dateDeparture;
    }
    
    public function getListPassenger() {
        return $this->listPassenger;
    }
    public function setListPassenger($listPassenger) {
        $this->listPassenger = $listPassenger;
    }

}