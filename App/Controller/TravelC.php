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

        var_dump($_SESSION);

        if (isset($_POST['submit'])) {

            if (empty($_POST['cityStart']) || empty($_POST['cityEnd'])) {
                $_SESSION['popup'] = new PopUp('error', 'Vous devez renseigner une ville de départ et une ville d\'arrivée');
                header('location: /amouv/voyage/creation');
                exit();
            }

            if (empty($_POST['dayDeparture']) || empty($_POST['timeDeparture'])) {
                $_SESSION['popup'] = new PopUp('error', 'Le jour et l\'heure de départ ');
                header('location: /amouv/voyage/creation');
                exit();
            }

            $dateDeparture = strtotime($_POST['dayDeparture'] . $_POST['timeDeparture']);

            if ($dateDeparture <= time()) {
                $_SESSION['popup'] = new PopUp('error', 'Votre départ ne peut pas être dans le passé');
                header('location: /amouv/voyage/creation');
                exit();
            }


            if (empty($_POST['car'])) {
                $_SESSION['user'] =  new PopUp('error', 'Vous devez choisir une voiture');
                header('location: /amouv/voyage/creation');
                exit();
            }



        }


        View::render('Travel/createTravel', ['slt' => 'bonjour']);



    } // public function createTravel()


}

