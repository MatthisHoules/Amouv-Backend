<?php

/**
 * 
 *  @title : resultTravel.php
 *  @author : Mathieu LEBRUN
 *  @author : Antoine DELAUNAY
 *  @author : Matthis HOULES
 * 
 *  @brief : result travel view
 * 
 */

    $listStyles = ['resultTravel.css'];
    $listJS = ['resultTravel.js'];

    ob_start();

?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABFVts7kUrlYvZRR9hm_jE8A9LYVoBvZY&libraries=places&callback=initMap"
async defer></script>

<main>
        <section id="researchInfo">
            <p class="pageTitle">
                A propos de votre recherche
            </p>

            <div class="row">
                <div class="line">
                    <p>
                        <span>
                            Depart :
                        </span>
                        <span id="departureCity">
                            <?= $_GET['cityStart'] ?>
                        </span>
                    </p>

                    <p>
                        <span>
                            Arrivée :
                        </span>
                        <span id="arrivalCity">
                            <?= $_GET['cityEnd'] ?>
                        </span>
                    </p>

                    <p>
                        <span>
                            Date du départ :
                        </span>
                        <span>
                            le
                        </span>
                        <span id="dayDeparture">
                            <?= $_GET['dayDeparture'] ?>
                        </span>
                        <span>
                            à
                        </span>
                        <span id="dayDeparture">
                            <?= $_GET['timeDeparture'] ?>
                        </span>
                    </p>
                </div>


                <div id="map">
                    
                </div>
            </div>
        </section>

        <section id="researchInfo">
            <p class="pageTitle">
                Résultats de votre recherche
            </p>

            <div class="travelList">
                <?php
                    foreach ($travels as $key => $value) {
                ?>
                    <div class="travel">
                        <div class="column">
                            <p class="DepartureCity">
                                <?= htmlspecialchars($value->getDeparture()) ?>
                            </p>
                            <p class="arrivalCity">
                                <?= htmlspecialchars($value->getArrival()) ?>
                            </p>
                            <p class="timeDeparture">
                                <?= htmlspecialchars($value->getDateDeparture()) ?>
                            </p>
                            <p class="creator">
                                <?= htmlspecialchars($value->getUser()->getFirstname()).' '.htmlspecialchars($value->getUser()->getLastname()) ?>
                            </p>
                        </div>

                        <div class="column">
                            <a href="/amouv/voyage?id=<?=$value->getId()?>" class="buttonMore more">
                                Plus d'informations <i class="fas fa-plus-circle"></i>
                            </a>
                            <a href="/amouv/discussion?travelId=<?=$value->getId()?>" class="buttonMore message">
                                Envoyer un message  <i class="fas fa-envelope-open-text"></i>
                            </a>
                        </div>


                    </div>
                <?php 
                    }
                ?>
            </div>
        </section>
    </main>




<?php

    $content = ob_get_clean();

    require_once(__DIR__.'/../templateUser.php');


?>