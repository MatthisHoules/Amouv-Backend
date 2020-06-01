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

// Homepage
$Router->add('/amouv', ['controller' => 'HomepageC@show']);

// Sign
$Router->add('/amouv/connexion', ['controller' => 'UserC@signIn']);
$Router->add('/amouv/inscription', ['controller' => 'UserC@signUp']);
$Router->add('/amouv/validation', ['controller' => 'UserC@validateAccount']);
$Router->add('/amouv/motdepasseoublie' , ['controller' => 'UserC@changePasswordMail']);
$Router->add('/amouv/cpwdmail' , ['controller' => 'UserC@changePassword']);
$Router->add('/amouv/deconnexion', ['controller' => 'UserC@signOut']);


// Travel
$Router->add('/amouv/voyage/creation', ['controller' => 'TravelC@createTravel']);
$Router->add('/amouv/voyage/recherche', ['controller' => 'TravelC@searchTravel']);
$Router->add('/amouv/voyage/resultats', ['controller' => 'travelC@resultTravel']);
$Router->add('/amouv/voyage', ['controller' => 'travelC@focusTravel']);


// Car
$Router->add('/amouv/voiture/creation', ['controller' => 'CarC@createCar']);

$Router->initialize();


?>