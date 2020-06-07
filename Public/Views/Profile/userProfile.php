<?php

/**
 * 
 *  @title : userProfile.php
 *  @author : Mathieu LEBRUN
 *  @author : Antoine DELAUNAY
 *  @author : Matthis HOULES
 * 
 *  @brief : view user profile
 * 
 */

    $listStyles = ['profile.css'];
    $listJS = [''];


    ob_start();

?>


<main>
    <section id="userInformations">
        <p class="pageTitle">
            Informations
        </p>

        <div class="row">
            <div class="column">
                <p class="line">
                    <?= htmlspecialchars($user->getFirstname()).' '.htmlspecialchars($user->getLastname())?>
                </p>
                <p class="line">
                    <?= $user->getMail()?>
                </p>
            </div>

            <div class="column">
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
                    <?= 
                        $stats['NBVoyCrea']
                    ?>
                    en tant que conducteur et
                    <?= 
                        $stats['NBVoyPass']
                    ?>
                    en tant que passager
                </p>
            </div>
        </div>


    </section>


    <section id="carContainer">
        <p class="pageTitle">
            Voitures de <?= htmlspecialchars($user->getFirstname()).' '.htmlspecialchars($user->getLastname())?>
        </p>            

        <div class="carList">
            <?php if (sizeof($user->getCars()) == 0) {?>
                <p class="noCar">
                    L'utilisateur ne possède pas de voiture
                </p>
            <?php } else {?>
            <?php foreach($user->getCars() as $key => $value) {?>
            <div class="car">
                <p class="line">
                    <span class="titleLine">
                        Nom : 
                    </span>
                    <span class="valueLine">
                        <?= htmlspecialchars($value->getModel()) ?>
                    </span>
                </p>

                <p class="line">
                    <span class="titleLine">
                        Nombre de sièges : 
                    </span>
                    <span class="valueLine">
                        <?= htmlspecialchars($value->getCar_seat()) ?>                 
                    </span>
                </p>

                <p class="line">
                    <span class="titleLine">
                        Motorisation : 
                    </span>
                    <span class="valueLine">
                        <?= htmlspecialchars($value->getMotorization()) ?>                 
                    </span>
                </p>

            
            
            </div>
            <?php }
                  } 
            ?>
        </div>

    </section>


    <section id="travelContainer">
        <p class="pageTitle">
            Voyages de <?= htmlspecialchars($user->getFirstname()).' '.htmlspecialchars($user->getLastname())?>
        </p>      

        <div class="voyageList">
            <?php
                if (sizeof($user->getListTravels()) == 0) {
            ?>
                <p class="noTravels">
                    L'utilisateur ne propose pas de voyage actuellement.
                </p>

            <?php } else { foreach ($user->getListTravels() as $key => $value) { ?>
                  
            <div class="voyage">
                <div class="column departureArrivalC">
                    <p class="line">
                        <?= htmlspecialchars($value->getDeparture()) ?>
                    </p>
                    <p class="line">
                        <i class="fas fa-angle-down"></i>
                    </p>
                    <p class="line">
                        <?= htmlspecialchars($value->getArrival()) ?>
                    </p>
                </div>

                <p class="line departure">
                    <?= htmlspecialchars($value->getDateDeparture()) ?>
                </p>

                <div class="line buttonLIne">

                    <a href="/amouv/voyage?id=<?=$value->getId()?>" class="more">
                        Plus d'informations <i class="fas fa-plus"></i>
                    </a>
                </div>
            </div>



            <?php } } ?>

        </div>
        
    </section>
</main>





<?php

    $content = ob_get_clean();

    require_once(__DIR__.'/../templateUser.php');


?>