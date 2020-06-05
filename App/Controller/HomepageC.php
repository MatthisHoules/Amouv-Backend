<?php

/**
 *  @title : HomepageC.php
 *  
 *  @author : Théo MOUMDJIAN
 *  @author : Guillaume RISCH
 * 
 *  @brief : homepage Controller
 *  
 */

// imports
require_once(__DIR__.'/../Model/User.php');
require_once(__DIR__.'/../../Core/PopUp.php');
require_once(__DIR__.'/../Model/Notification.php');
session_start();

 class HomepageC {

    /**
     *  @name : show
     *  @param : void
     *  @return : void
     * 
     *  @brief : init AMOUV Homepage
     * 
     */
    public function show() {
        View::render('Homepage/homepage', ['slt' => 'bonjour']);
    
    } // public function show()


 }

?>