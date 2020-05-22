<?php

/**
 * 
 *  @title : homepage.php
 *  @author : Mathieu LEBRUN
 *  @author : Antoine DELAUNAY
 *  @author : Matthis HOULES
 * 
 *  @brief : homepage view
 * 
 */

    $listStyles = ['homepage.css'];
    $listJS = [];

    ob_start();

?>


<main>
    slt a tous
</main>




<?php

    $content = ob_get_clean();

    if (isset($_SESSION['user'])) {
        require_once(__DIR__.'/../templateUser.php');
    } else {
        require_once(__DIR__.'/../templateGuest.php');
    }

?>