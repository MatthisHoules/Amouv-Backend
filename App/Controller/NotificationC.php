<?php

/**
 *  @title : NotificationC.php
 *  
 *  @author : Théo MOUMDJIAN
 *  @author : Guillaume RISCH
 *  @refractor : Matthis HOULES
 *  
 *  @brief : notification controller
 */


// imports
require_once(__DIR__.'/../Model/User.php');
require_once(__DIR__.'/../Model/Notification.php');
require_once(__DIR__.'/../../Core/PopUp.php');
session_start();

class NotificationC {


    /**
     * 
     *  @name : __construct
     * 
     *  @param void
     *  @return void
     * 
     *  @brief : Notification middleware
     * 
     */
    function __construct() {

        if (!isset($_SESSION['user'])) {

            $_SESSION['popup'] = new PopUp('error', 'vous devez être connecté pour pouvoir accéder à cette page');
            header('location: /AMOUV/connexion');
        }

        // refresh notification
        $_SESSION['user']->setNotification(Notification::getListNotification($_SESSION['user']->getId()));

    } // __construct()




    /**
     * 
     *  @name : notificationPage
     * 
     *  @param void
     *  @return void
     * 
     *  @brief : notification page controller
     * 
     */
    public function notificationPage() {

        if (empty($_GET['id']) || !is_int($_GET['id'])) {
            $_SESSION['popup'] = new PopUp('error', 'Erreur redirection notification');
            header('location: /AMOUV/');
            exit();
        }

        
        // check if notification exists
        $notification = Notification::getNotification($_GET['id']);

        // notification not exists
        if (!$notication) {
            $_SESSION['popup'] = new PopUp('error', 'Erreur redirection notification');
            header('location: /AMOUV/');
            exit();
        }


        // check if 




    } // public function notificationPage()



} // class NotificationC




?>
