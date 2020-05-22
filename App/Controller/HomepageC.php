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


 class HomepageC {

    function __construct() {


        View::render('Homepage/homepage', ['slt' => 'bonjour']);
    }


 }

?>