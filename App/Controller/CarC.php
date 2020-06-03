<?php


/**
 * 
 *  @name : CarC.php
 *  
 *  @author : Guillaume RISCH
 *  @author : Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief :  car controller pages
 * 
 * 
 */


require_once(__DIR__.'/../Model/Car.php');
require_once(__DIR__.'/../Model/User.php');
require_once(__DIR__.'/../../Core/PopUp.php');
session_start();

 class CarC {


    /**
     *  @name : createCar
     *  @param : void
     * 
     *  @return : void
     * 
     *  @brief : create car controller
     * 
     */
    public function createCar() {
        
        if (!isset($_SESSION['formcar'])) {
            if(empty($_POST['Voiture']) || empty($_POST['Places']) || empty($_POST['Couleur']) || empty($_POST['Motorisation'])){
            $_SESSION['popup'] = new PopUp('error', 'Tout les champs doivent etre remplie');
            header('location: /AMOUV/voiture/creation');
            exit;
        }

            }
            View::render('Car/carCreate',['']);
     
    }// public function createCar()
 }