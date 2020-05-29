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

        var_dump($result);

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
}



?>