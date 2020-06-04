<?php


/**
 * 
 *  @name : CarC.php
 *  
 *  @author : Guillaume RISCH
 *  @author : Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief :  car controller pages
 * 
 * 
 */


require_once(__DIR__.'/../Model/User.php');
require_once(__DIR__.'/../Model/Chat.php');
require_once(__DIR__.'/../../Core/PopUp.php');

session_start();

class ChatC {

     /**
     *  @name : createChat
     *  @param : void
     * 
     *  @return : void
     * 
     *  @brief : create Chat controller
     * 
     */
    public function createChat() {
        if (!empty($_POST['submit'])) {

            if (empty($_POST['message']) || empty($_POST['pseudo'])) {
                // ERREUR
            }

            // on continue le traitement

            $pseudo = htmlspecialchars($_POST['pseudo']);
            $message = htmlspecialchars($_POST['message']);

            Chat::insertmsg($pseudo, $message);

        } 
        
        // get messages
        $listMessages = Chat::getmsg(1);


        View::render('Chat/chatcreate',['listMessage' => $listMessages]);
    }

}