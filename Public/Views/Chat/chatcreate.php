<?php

/**
 * 
 *  @title : carCreate.php
 *  @author : Guillaume Risch
 *  @author : Matthis HOULES
 * 
 *  @brief : Chat view
 * 
 */


?>
<html>
    <head>
        <title>Chat view</title>
        <meta charset="utf-8">
    </head>
    <body>

        <?php  var_dump($listMessage) ?>

        <?php
            foreach ($listMessage as $key => $value) {
        ?>

            <div>
                <p>
                    <?= $value['message'] ?>
                </p>
            </div>

        <?php
            }
        ?>



        <form method="POST" action="">
            <input type="text" name="pseudo"
            placeholder="PSEUDO" /><br />
            <textarea type="text" name="message" placeholder="MESSAGE"></textarea><br />
            <input type="submit" value="Envoyer" name="submit"/>
        </form>
    </body>
</html>
        
