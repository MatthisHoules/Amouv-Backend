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

    $listStyles = ['focusDiscussion.css'];
    $listJS = [''];


    ob_start();

?>


<main>

    <section id="travelId">
        <p>
            <span>
                <span class="spanTitle">
                    Départ :
                </span>
                <?= $travel->getDeparture() ?>, arrivée : <?=  $travel->getArrival() ?>
            </span>

            <span>
                <span class="spanTitle">
                    Date du depart :
                </span>
                <?= $travel->getDateDeparture() ?>
            </span>
        </p>
        <div class="moreC">
            <a href="/amouv/voyage?id=<?= $travel->getId() ?>" class="more">
                Voir plus <i class="fas fa-search"></i>
            </a>

        </div>
    </section>


    <section id="discussionContainer">
        <div class="discussionList">

            <?php 
                foreach ($discussion->getListMessages() as $key => $message) {
                    
                    if ($message->getUser()->getId() == $_SESSION['user']->getId()) {
                        $divClass = 'you';
                    } else {
                        $divClass = 'other';
                    }
            ?>

                <div class="messageU <?= $divClass ?>">
                    <p class="text">
                        <?= 
                            $message->getMessage();
                        ?>
                    </p>
                    <p class="author">
                        <?= 
                            $message->getUser()->getFirstname(). ' ' .$message->getUser()->getLastname();
                            ?>
                            <?= 
                                $message->getCreated_at();
                            ?>
                    </p>

                </div>


            <?php
                }
            ?>

                
            <form action="" method="post" class="formSendMEssage">

                <textarea name="messageInput" id="messageInput" cols="30" rows="10"></textarea>
                <button type="submit" name="submit" value="submit">
                    Envoyer <i class="fas fa-paper-plane"></i>
                </button>                
            </form>
        </div>
    </section>


    
</main>



<?php

    $content = ob_get_clean();

    require_once(__DIR__.'/../templateUser.php');


?>