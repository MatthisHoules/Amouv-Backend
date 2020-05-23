<?php

/**
 *  @title : HomepageC.php
 *  
 *  @author : Théo MOUMDJIAN
 *  @author : Guillaume RISCH
 *  @refractor : Matthis HOULES
 *  
 */


// imports
require_once(__DIR__.'/../Model/User.php');
require_once(__DIR__.'/../Model/Confirmation.php');
require_once(__DIR__.'/../../Core/Mail.php');
require_once(__DIR__.'/../../Core/PopUp.php');
session_start();
 
 class UserC {


    /**
     *  @name : signUp
     *  @param : void
     *  @return : void
     * 
     *  @brief : Sign Up page Controller
     * 
     */
    public function signUp() {
        if (isset($_POST['submit'])) {
            var_dump($_POST);
            var_dump(empty($_POST['mailInput']));


            // mail
            if (empty($_POST['mailInput']) || !filter_var($_POST['mailInput'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['popup'] = new PopUp('error', 'Il faut saisir un mail valide.');
                header('location: /AMOUV/inscription');      
                exit;
            }
            // Check if mail exists
            if (User::isMailExist($_POST['mailInput'])) {
                $_SESSION['popup'] = new PopUp('error', 'L\'adresse mail renseigné est déja utilisé.');
                header('location: /AMOUV/inscription');      
                exit;
            }


            // LastName & Firstname
            if (empty($_POST['firstnameInput']) || empty($_POST['lastnameInput'])) {
                $_SESSION['popup'] = new PopUp('error', 'Le prénom et le nom de famille doivent être renseignés');
                header('location: /AMOUV/inscription');      
                exit;
            }


            if (empty($_POST['passwordInput']) || empty($_POST['RpasswordInput']) || $_POST['passwordInput'] != $_POST['RpasswordInput']){
                $_SESSION['popup'] = new PopUp('error', 'Les mots de passe ne sont pas identiques.');
                header('location: /AMOUV/inscription');      
                exit;
            }

            $cryptedPwd = password_hash($_POST['passwordInput'], PASSWORD_BCRYPT);

            
            // insertion dans la base de données
            User::newUser($_POST['mailInput'], $_POST['lastnameInput'], $_POST['firstnameInput'], $cryptedPwd);
            
            // Creation d'un code pour l'envoie du mail de confirmation
            $code = AleatoryString();


            $mail = new Mail;
            $mail->sendMail(['mail' => 'matthis.houles@gmail.com', 'name' => 'Matthis HOULES'], 'Merci de confirmer votre compte.', ['confirmationAccount', 'var' => $code]);
            
            
            $_SESSION['popup'] = new PopUp('success', 'Votre compte a bien été créé, mais il n\'est pas encore actif. Pour l\'activer, veuillez vérifier vos mail.');
            header('location: /AMOUV/inscription'); 
        }
        

        View::render('Sign/SignUp', []);


    } // public function signUp()



    /**
     *  @name : validateAccount
     *  @param : void
     *  @return : void
     * 
     *  @brief : validate Account with mail
     * 
     */
    public function validateAccount() {

        if (!isset($_GET['code']) || strlen($_GET['code']) != 10) {
            $_SESSION['popup'] = new PopUp('error', 'Le code fourni est non valide');
            header('location: /AMOUV/inscription');      
            exit;
        }


        
        $isUser = Confirmation::isExist($_GET['code'], 'account');
        if (!$isUser) {
            $_SESSION['popup'] = new PopUp('error', 'Le code n\'existe pas ou votre compte à déja été activé !');
            header('location: /AMOUV/inscription');
            exit;
        }
        

        // Activer le compte
        User::activateAccount($isUser[0]['user_id']);

        // desactiver la confirmation
        Confirmation::disable($_GET['code']);


        $_SESSION['popup'] = new PopUp('success', 'Votre compte est maintenant actif, veuillez vous connecter !');
        header('location: /AMOUV/connexion');
        exit;


    } // public function validateAccount()






    /**
     *  @name : signIn
     *  @param : void
     *  @return : void
     * 
     *  @brief : SignUp page Controller
     * 
     */
    public function signIn() {

        if (isset($_POST['submit'])) {
                
            // mail
            if (empty($_POST['mailInput']) || !filter_var($_POST['mailInput'], FILTER_VALIDATE_EMAIL)) {

                $_SESSION['popup'] = new PopUp('error', 'L\'email renseigné n\'est pas valide !');
                header('location: /AMOUV/connexion');
                exit;

            }

            if (empty($_POST['pwdInput'])) {
                $_SESSION['popup'] = new PopUp('error', 'Mot de passe renseigné non valide');
                header('location: /AMOUV/connexion');
                exit;
            }


            $isUser = User::isUserExist($_POST['mailInput'], $_POST['pwdInput']);

            if (!$isUser) {
                $_SESSION['popup'] = new PopUp('error', 'Combinaison Email et mot de passe inconnus');
                header('location: /AMOUV/connexion');
                exit;
            }


            if ($isUser->getActive() == 0) {
                $_SESSION['popup'] = new PopUp('error', 'Votre compte doit être activé, veuillez regarder vos email.');
                header('location: /AMOUV/connexion');
                exit;
            }

            $_SESSION['user'] = $isUser;
            var_dump($_SESSION['user']);
            

            var_dump($_SESSION);

            $_SESSION['popup'] = new PopUp('success', 'Vous êtes maintenant connecté');
            header('location: /AMOUV/');
            exit;

        }

        View::render('Sign/SignIn', []);


    } // public function signIn()
    
    
}


/**
 *  @name : AleatoryString
 * 
 *  @param : void
 *  
 *  @return : aleatory string : len:10
 * 
 *  @brief : create and return a string of 10 aleatory char.
 * 
 */
function AleatoryString() {
    $charAvailables = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < 10; $i++) {
        $str .= $charAvailables[rand(0, strlen($charAvailables) - 1)];
    
    }
    return $str;
} // function AleatoryString()


?>