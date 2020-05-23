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