<?php

/**
 * 
 *  @title : focusTravel.php
 *  @author : Mathieu LEBRUN
 *  @author : Antoine DELAUNAY
 *  @author : Matthis HOULES
 * 
 *  @brief : view travel
 * 
 */

    $listStyles = ['focusTravel.css'];
    $listJS = ['resultTravel.js'];

    ob_start();

?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABFVts7kUrlYvZRR9hm_jE8A9LYVoBvZY&libraries=places&callback=initMap"
async defer></script>

<main>


        <section id="researchInfo">
           <p class="pageTitle">
                Informations
           </p>

           <div class="row">
                <div class="colC">
                    <div class="column">
                        <p class="Title">
                            Voyage
                        </p>
                        <p class="item">
                            Départ : <?= htmlspecialchars($travel->getDeparture()) ?>
                        </p>
                        <p class="item">
                            Départ : <?= htmlspecialchars($travel->getArrival()) ?>
                        </p>
                        <p class="item">
                            Date et heure du départ : 
                            <br><?= htmlspecialchars($travel->getDateDeparture()) ?>
                        </p>
                    </div>

                    <div class="column">
                        <p class="Title">
                            Voiture
                        </p>
                        <p class="item">
                            <?= htmlspecialchars(ucfirst($travel->getCar()->getModel())) ?>
                        </p>
                        <p class="item">
                            <?= htmlspecialchars($travel->getCar()->getCar_seat()) ?> places
                        </p>
                        <p class="item">
                            Moteur <?= htmlspecialchars($travel->getCar()->getMotorization()) ?>
                        </p>
                    </div>
                </div>

                <div class="column">
                    <p class="Title">
                        Conducteur
                    </p>
                    <p class="item">
                        <?= htmlspecialchars($travel->getUser()->getFirstname()). ' '.htmlspecialchars($travel->getUser()->getLastname()) ?>
                    </p>
                    <p class="item">
                        <?= htmlspecialchars($travel->getUser()->getMail()) ?>
                    </p>
                    <p class="Title">
                        Statistiques
                    </p>
                    <p class="item">
                        <?= 
                            $stats['tot']
                        ?>

                        <?php 
                            if ($stats['tot'] <= 1) {
                        ?>
                            voyage
                        <?php
                            } else {
                        ?>
                            voyages
                        <?php
                            }
                        ?>
                        dont
                    </p>
                    <p class="item">
                        <?= 
                            $stats['NBVoyCrea']
                        ?>
                        en conducteur et
                    </p>
                    <p class="item">
                        <?= 
                            $stats['NBVoyPass']
                        ?>
                        en passager
                    </p>


                    <?php  if ($_SESSION['user']->getId() != $travel->getUser()->getId()) { ?>

                    <p class="item buttonItem">
                        <a href="/amouv/discussion?travelId=<?=$travel->getId()?>" class="buttonMore message">
                            Envoyer un message  <i class="fas fa-envelope-open-text"></i>
                        </a>
                    </p>

                    <?php } ?>
                </div>
           </div>


        

        </section>

        <section id="researchInfo">
           <p class="pageTitle">
                Détails
           </p>

           <div class="item">

                <?php    if ($nbPass != $travel->getSeats()) { ?>

                        <p class="descrItem">
                            Il y a actuellement <?= $nbPass ?> réservation pour ce voyage sur <?= $travel->getSeats() ?> places au total. <?= $travel->getLugage() ?> bagage(s) par personne.
                        </p>

                        <?php if (!Passenger::isPassengerInTravel($_SESSION['user']->getId(), $travel)) { ?>
                        <form action="" method="post">
                            <button type="submit" class="buttonMore message" name="submit" value="submit">
                                Réserver une place <i class="fas fa-car"></i>
                            </button>
            

                <?php 
                        } else { ?>
                            <p class="descrItem">
                                Vous faîtes déja partie de ce voyage !
                            </p>
                <?php } 
                    } else {
                ?>

                    <p class="descrItem">
                        Ce voyage est actuellement complet, veuillez chercher un autre voyage, ou contacter le conducteur pour savoir si une place est de nouveau disponible.
                    </p>
                

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