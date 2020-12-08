<?php

/**
 *  @title : Car.php
 * 
 *  @author : Guillaume RISCH
 *  @author : Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief : Car model
 * 
 */
class Car extends Model{

    protected $id;
    protected $color;
    protected $car_seat;
    protected $model;
    protected $motorization;


    /**
     *  @name : __construct
     *  
     *  @param : id
     *  @param : color
     *  @param : car_seat
     *  @param : model
     *  @param : motorization
     * 
     *  @brief : constructor class Model
     * 
     */
    function __construct($id, $color, $car_seat, $model, $motorization) {
        $this->id = $id;
        $this->color = $color;
        $this->car_seat = $car_seat;
        $this->model = $model;
        $this->motorization = $motorization;
    }



    /**
     *  @name : getUserCar
     * 
     *  @param : userId : int
     * 
     *  @brief : array of Car if user have car, false instead
     * 
     */
    public static function getUserCar($userId) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT * 
                              FROM `car`
                              WHERE `user_id` = ?
                            ');
        $stmt->execute([$userId]);

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        }

        $listCar = [];
        foreach ($result as $key => $value) {
            array_push($listCar, new Car ($value['car_id'], 
                                          $value['color'], 
                                          $value['car_seat'], 
                                          $value['model'], 
                                          $value['motorization']));
        }

        return $listCar;


    } // public static function getUserCar($userId)


    /**
     *  @name : carBelongUser
     *  
     *  @param : userId
     *  @param : carId
     * 
     *  @return : bool, if car belong to user return Car object, false instead
     * 
     */
    public static function carBelongUser($userId, $carId) {

        $DB = static::DBConnect();
        $stmt = $DB->prepare('SELECT * 
                              FROM `car`
                              WHERE `user_id` = ?
                              AND `car_id` = ?');
        $stmt->execute([$userId, $carId]);

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        }
        return new Car( $result[0]['car_id'], 
                        $result[0]['color'], 
                        $result[0]['car_seat'], 
                        $result[0]['model'], 
                        $result[0]['motorization']
                    );

    } // public sttaic function carBelongUser($userId, $carId)



    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getColor(){
		return $this->color;
	}

	public function setColor($color){
		$this->color = $color;
	}

	public function getCar_seat(){
		return $this->car_seat;
	}

	public function setCar_seat($car_seat){
		$this->car_seat = $car_seat;
	}

	public function getModel(){
		return $this->model;
	}

	public function setModel($model){
		$this->model = $model;
	}

	public function getMotorization(){
		return $this->motorization;
	}

	public function setMotorization($motorization){
		$this->motorization = $motorization;
	}
}



?>