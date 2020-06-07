<?php

/**
 *  @title : ProfileC.php
 *  
 *  @author : Théo MOUMDJIAN
 *  @author : Guillaume RISCH
 *  @refractor : Matthis HOULES
 *  
 *  @brief : profile pages controller
 */


// imports
require_once(__DIR__.'/../Model/User.php');
require_once(__DIR__.'/../Model/Travel.php');
require_once(__DIR__.'/../Model/Discussion.php');
require_once(__DIR__.'/../Model/Message.php');
require_once(__DIR__.'/../../Core/PopUp.php');
require_once(__DIR__.'/../Model/Notification.php');

session_start();


class ProfileC {


    /**
     * 
     *  @name : __construct
     * 
     *  @param void
     * 
     *  @return void
     * 
     *  @brief : middleware ProfileC (check if user is connected) & refresh notifications
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
     *  @name : userProfile
     * 
     *  @param void
     * 
     *  @return void
     * 
     *  @brief : user profile
     * 
     */
    public function userProfile() {

        if (empty($_GET['id'])) {
            $_SESSION['popup'] = new PopUp('error', 'Erreur dans l\'URL, aucun utilisateur trouvé');
            header('location: /amouv/');
            exit();
        }

        $user = User::isUserWithId($_GET['id']);
        if (!$user) {
            $_SESSION['popup'] = new PopUp('error', 'Erreur dans l\'URL, aucun utilisateur trouvé');
            header('location: /amouv/');
            exit();
        }
        

        // user travels
        $user->setListTravels(Travel::getUserTravelsActive($_GET['id']));

        // user stats
        $stats = User::getUserStats($_GET['id']);
        $stats['tot'] = $stats['NBVoyCrea'] + $stats['NBVoyPass']; 
        

        // Views
        View::render('Profile/userProfile', [
            'user' => $user,
            'stats' => $stats
        ]);

    } // public function userProfile()


    /**
     * 
     *  @name : myProfile
     * 
     *  @param void
     *  @param void
     * 
     *  @return void
     * 
     *  @brief : current session user profile (modify)
     * 
     */
    public function myProfile() {

        // refresh user travel
        $_SESSION['user']->setListTravels(Travel::getUserTravelsActive($_GET['id']));

        // user stats
        $stats = User::getUserStats($_GET['id']);
        $stats['tot'] = $stats['NBVoyCrea'] + $stats['NBVoyPass']; 


        View::render('Profile/myProfile');

    } //  public function myProfile()

} // class ProfileC 
