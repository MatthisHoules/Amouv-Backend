<?php

/**
 *  @title : TravelC.php
 *  
 *  @author : Théo MOUMDJIAN
 *  @author : Guillaume RISCH
 *  @refractor : Matthis HOULES
 *  
 *  @brief : travel pages controller
 */

// imports
require_once(__DIR__.'/../Model/User.php');
require_once(__DIR__.'/../../Core/PopUp.php');
session_start();


class TravelC {



    /**
     * 
     *  @name : __construct
     * 
     *  @param void
     * 
     *  @return void
     * 
     *  @brief : middleware TravelC (check if user is connected)
     */
    function __construct() {
        if (!isset($_SESSION['user'])) {

            $_SESSION['popup'] = new PopUp('error', 'vous devez être connecté pour pouvoir accéder à cette page');
            header('location: /AMOUV/connexion');
        }

    } // function __construct()



    /**
     * 
     *  @name : createTravel
     * 
     *  @param void
     *  
     *  @return void
     * 
     *  @brief : create Travel page
     * 
     */
    public function createTravel() {

        View::render('Travel/createTravel', ['slt' => 'bonjour']);



    } // public function createTravel()


}

