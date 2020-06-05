<?php

/**
 *  @title : DiscussionC.php
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
require_once(__DIR__.'/../Model/Discussion.php');
require_once(__DIR__.'/../Model/Message.php');
require_once(__DIR__.'/../../Core/PopUp.php');
require_once(__DIR__.'/../Model/Notification.php');
session_start();


class DiscussionC {

    /**
     * 
     *  @name : __construct
     * 
     *  @param void
     * 
     *  @return void
     * 
     *  @brief : middleware DiscussionC (check if user is connected)
     */
    function __construct() {
        if (!isset($_SESSION['user'])) {

            $_SESSION['popup'] = new PopUp('error', 'vous devez être connecté pour pouvoir accéder à cette page');
            header('location: /AMOUV/connexion');
        }

    } // function __construct()



    /**
     *  @name : focusDiscussion
     *  
     *  @param void
     *  @return void
     * 
     *  @brief : Focus discussion
     * 
     * 
     */
    public function focusDiscussion() {
        if (!empty($_GET['travelId'])) {
    
            $travel = Travel::getTravel($_GET['travelId']);
            
    
            if (!$travel) {
                $_SESSION['popup'] = new PopUp('error', 'Erreur dans l\'URL, voyage inconnu');
                header('location: /amouv/voyage/recherche');
                exit();
            }
    


            if ($_SESSION['user']->getId() == $travel->getUser()->getId()) {
                $_SESSION['popup'] = new PopUp('error', 'Erreur dans l\'URL, impossible de créer une discussion avec soi-même');
                header('location: /amouv/');
                exit();
            }
    

    
    
            $Discussion = Discussion::getDiscussion($_GET['travelId'], $_SESSION['user']->getId());
    
            // If discuss not exists
            if (!$Discussion) {

                Discussion::createDiscussion($_SESSION['user']->getId(), $_GET['travelId'], $travel->getUser()->getId());
                $_SESSION['popup'] = new PopUp('success', 'La discussion entre vous et le conducteur a été créé.');
                header('location: /amouv/discussion?travelId='.$_GET['travelId']);

            }

            if (!empty($_POST['submit'])) {
    
                if (empty($_POST['messageInput'])) {
    
                    $_SESSION['popup'] = new PopUp('error', 'Le message ne peut pas être vide');
                    header('location: /amouv/discussion?travelId='.$_GET['travelId']);
                    exit();
    
                    
                }
                
                Message::insertMsg($Discussion->getId(), $_POST['messageInput'], $_SESSION['user']->getId());
                $_SESSION['popup'] = new PopUp('success', 'Message envoyé !');
                header('location: /amouv/discussion?travelId='.$_GET['travelId']);
                exit();
            }

        } else if (!empty($_GET['discussId']) ) {

            $Discussion = Discussion::getDiscussionById($_GET['discussId']);
            
            if (!$Discussion) {
                $_SESSION['popup'] = new PopUp('error', 'La discussion n\'existe pas');
                header('location: /amouv/discussion?travelId='.$_GET['travelId']);
                exit();
            }

            // check if user in conductor or passenger
            if (!Discussion::isUserInDiscussion($_SESSION['user']->getId())) {
                $_SESSION['popup'] = new PopUp('error', 'La discussion n\'existe pas');
                header('location: /amouv/');
                exit();
            }


            // get travel
            $travel = Travel::getTravel($Discussion->getTravel_id());

            if (!empty($_POST['submit'])) {
    
                if (empty($_POST['messageInput'])) {
    
                    $_SESSION['popup'] = new PopUp('error', 'Le message ne peut pas être vide');
                    header('location: /amouv/discussion?discussId='.$_GET['discussId']);
                    exit();
    
                }

                Message::insertMsg($Discussion->getId(), $_POST['messageInput'], $_SESSION['user']->getId());
                $_SESSION['popup'] = new PopUp('success', 'Message envoyé !');
                header('location: /amouv/discussion?discussId='.$_GET['discussId']);
                exit();

            }
        }




        View::render('Discussion/focusDiscussion', ['discussion' => $Discussion,
                                                    'travel' => $travel
                                                   ]);

    } // public function focusDiscussion()





}




?>