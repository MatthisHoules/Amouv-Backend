<?php
/**
 *  @title : index.php
 *  @author : Guillaume RISCH
 *  @author : Matthis HOULES
 * 
 *  @brief : Routing table & start page
 */
 
// require Core files
require_once('./Core/Model.php');
require_once('./Core/View.php');


// Router
require_once('./Core/Router.php');
$Router = new Router;


/**
 *  Add your routes here
 */
$Router->add('/amouv/signin', ['controller' => 'UserC']);
$Router->add('/amouv', ['controller' => 'HomepageC']);



$Router->initialize();


?>