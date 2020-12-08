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
require_once(__DIR__.'/../Model/Travel.php');
require_once(__DIR__.'/../../Core/PopUp.php');
require_once(__DIR__.'/../Model/Notification.php');
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
        $_SESSION['user']->setNotification(Notification::getListNotification($_SESSION['user']->getId()));


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

        if (isset($_POST['submit'])) {

            // Cities of departure & arrival
            if (empty($_POST['cityStart']) || empty($_POST['cityEnd'])) {
                $_SESSION['popup'] = new PopUp('error', 'Vous devez renseigner une ville de départ et une ville d\'arrivée');
                header('location: /amouv/voyage/creation');
                exit();
            }

            // Day & time of departure
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


            // Car
            $carChoose = Car::carBelongUser($_SESSION['user']->getId(), $_POST['car']);
            if (empty($_POST['car']) || !$carChoose) {
                $_SESSION['popup'] =  new PopUp('error', 'Vous devez choisir une voiture valide');
                header('location: /amouv/voyage/creation');
                exit();
            }


            if (empty($_POST['nbseat']) || !ctype_digit($_POST['nbseat']) || $_POST['nbseat'] >= $carChoose->getCar_seat()) {
                $_SESSION['popup'] =  new PopUp('error', 'Votre nombre de siège est incorrect (soit vide soit supérieur au nombre de places de votre voiture.)');
                header('location: /amouv/voyage/creation');
                exit();
            }

            if (empty($_POST['nbLugage']) ||  !ctype_digit($_POST['nbLugage']) || $_POST['nbLugage'] < 0) {
                $_SESSION['popup'] =  new PopUp('error', 'Nombre de bagages par personne incorrect');
                header('location: /amouv/voyage/creation');
                exit(); 
            }

            //    public static function insertNewTravel($id_car, $departure, $arrival, $date_dep, $seats, $smoking, $lugage) {
        

            Travel::insertNewTravel($_POST['car'],
                                    $_POST['cityStart'],
                                    $_POST['cityEnd'],
                                    $dateDeparture,
                                    (int)$_POST['nbseat'],
                                    false,
                                    (int)$_POST['nbLugage']
                                    );
            
            $_SESSION['popup'] =  new PopUp('success', 'Votre voyage a bien été créé !');
            header('location: /amouv/');
            exit(); 
                    
                
        }

        if (empty($_SESSION['user']->getCars())) {
            $_SESSION['popup'] =  new PopUp('error', 'Vous devez posséder une voiture.');
            header('location: /amouv/voiture/creation');
            exit(); 
        }

        View::render('Travel/createTravel', []);

    } // public function createTravel()


    /**
     *  @name : searchTravel
     *  
     *  @param : void
     *  @return : void
     * 
     *  @brief : search Trave page controller
     */
    public function searchTravel() {

        if (isset($_POST['submit'])) {

            // Cities of departure & arrival
            if (empty($_POST['cityStart']) || empty($_POST['cityEnd'])) {
                $_SESSION['popup'] = new PopUp('error', 'Vous devez renseigner une ville de départ et une ville d\'arrivée');
                header('location: /amouv/voyage/recherche');
                exit();
            }

            // Day & time of departure
            if (empty($_POST['dayDeparture']) || empty($_POST['timeDeparture'])) {
                $_SESSION['popup'] = new PopUp('error', 'Le jour et l\'heure de départ ');
                header('location: /amouv/voyage/recherche');
                exit();
            }

            $dateDeparture = strtotime($_POST['dayDeparture'] . $_POST['timeDeparture']);

            if ($dateDeparture <= time()) {
                $_SESSION['popup'] = new PopUp('error', 'Votre départ ne peut pas être dans le passé');
                header('location: /amouv/voyage/recherche');
                exit();
            }

            $link = '/amouv/voyage/resultats?cityStart='.$_POST['cityStart']
                            .'&cityEnd='.$_POST['cityEnd']
                            .'&dayDeparture='.$_POST['dayDeparture']
                            .'&timeDeparture='.$_POST['timeDeparture'];
            header('location: '.$link);
            exit();
            
        }



        View::render('Travel/searchTravel', []);
    } // public function searchTravel()



    /**
     *  @name : resultTravel
     *  
     *  @param : void
     *  @return : vois
     * 
     *  @brief : result travel controller
     */
    public function resultTravel() {

        // check $_GET values
        // Cities of departure & arrival
        if (empty($_GET['cityStart']) || empty($_GET['cityEnd'])) {
            $_SESSION['popup'] = new PopUp('error', 'Vous devez renseigner une ville de départ et une ville d\'arrivée');
            header('location: /amouv/voyage/recherche');
            exit();
        }

        // Day & time of departure
        if (empty($_GET['dayDeparture']) || empty($_GET['timeDeparture'])) {
            $_SESSION['popup'] = new PopUp('error', 'Le jour et l\'heure de départ ');
            header('location: /amouv/voyage/recherche');
            exit();
        }

        $dateDeparture = strtotime($_GET['dayDeparture'] . $_GET['timeDeparture']);

        if ($dateDeparture <= time()) {
            $_SESSION['popup'] = new PopUp('error', 'Votre départ ne peut pas être dans le passé');
            header('location: /amouv/voyage/recherche');
            exit();
        }


        $results = Travel::searchTravels($_GET['cityStart'], $_GET['cityEnd'], $dateDeparture);

        View::render('Travel/resultTravel', ['travels' => $results]);


    } // public function resultTravel()



    /**
     *  @name : focusTravel
     *  
     *  @param void
     *  @return void
     * 
     *  @brief : focus travel page
     */
    public function focusTravel() {

        if (empty($_GET['id'])) {
            $_SESSION['popup'] = new PopUp('error', 'Erreur dans l\'URL, voyage recherché inconnu');
 
            header('location: /amouv/voyage/recherche');
            exit();
        }

        $travel = Travel::getTravel($_GET['id']);
        

        if (!$travel) {
            $_SESSION['popup'] = new PopUp('error', 'Erreur dans l\'URL, voyage recherché inconnu');

            header('location: /amouv/voyage/recherche');
            exit();
        }


        $stats = User::getUserStats($travel->getUser()->getId());

        $stats['tot'] = $stats['NBVoyCrea'] + $stats['NBVoyPass'];


        $NBPassenger = Travel::getCountTravelPassenger($_GET['id'])[0]['NBPassenger'];

        View::render('Travel/focusTravel', [ 'travel' => $travel,
                                             'stats' => $stats,
                                             'nbPass' => $NBPassenger
                                           ]);

    } // public function focusTravel()





}

