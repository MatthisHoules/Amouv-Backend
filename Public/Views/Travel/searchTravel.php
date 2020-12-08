<?php

/**
 * 
 *  @title : createTravel.php
 *  @author : Mathieu LEBRUN
 *  @author : Antoine DELAUNAY
 *  @author : Matthis HOULES
 * 
 *  @brief : homepage view
 * 
 */

    $listStyles = ['createSearchTravel.css'];
    $listJS = ['createTravel.js'];

    ob_start();

?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABFVts7kUrlYvZRR9hm_jE8A9LYVoBvZY&libraries=places&callback=initMap"
async defer></script>


<main>
    <p class="mainTitle">
        Rechercher un trajet
    </p>


    <form action="" method="post">
        <div class="formContainer">
            <div class="leftSide">
                <div class="inputContainer">
                    <label for="start">Départ</label>
                    <input type="hidden" name="cityStart" id="cityStart">
                    <input type="text" name="start" id="start">
                </div>
                <div class="inputContainer">
                    <label for="end">Arrivée</label>
                    <input type="hidden" name="cityEnd" id="cityEnd">
                    <input type="text" name="end" id="end">
                </div>
                <div class="inputContainer">
                    <label for="dayDeparture">Jour du départ</label>
                    <input type="date" name="dayDeparture" id="dayDeparture">
                </div>
                <div class="inputContainer">
                    <label for="timeDeparture">Heure du départ</label>
                    <input type="time" name="timeDeparture" id="timeDeparture">
                </div>
            </div>


            <div class="rightSide">
                <div id="map"></div>
                <div id="ETTCC">
                    <p>
                        Temps de voyage estimé :
                    </p>
                    <p id="ETTvalue">XXXX</p>
                </div>
            </div>
        </div>

        <div class="submitContainer">
            <button type="submit" value="submit" name="submit" id="submitBtn">
                Rechercher un trajet 
            </button>
        </div>
    </form>
</main>



<?php

    $content = ob_get_clean();

    require_once(__DIR__.'/../templateUser.php');

?>