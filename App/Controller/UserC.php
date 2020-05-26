<?php

/**
 *  @title : UserC.php
 *  
 *  @author : Théo MOUMDJIAN
 *  @author : Guillaume RISCH
 *  @refractor : Matthis HOULES
 *  
 *  @brief : User pages controller
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
     *  @param  void
     *  @return void
     * 
     *  @brief : Sign Up page Controller
     * 
     */
    public function signUp() {
        if (isset($_POST['submit'])) {


            // mail
            if (empty($_POST['mailInput']) || !filter_var($_POST['mailInput'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['popup'] = new PopUp('error', 'Il faut saisir un mail valide.');
                header('location: /AMOUV/inscription');      
                exit;
            }
            // Check if mail exists

            $isUser = User::isMailExist($_POST['mailInput']);


            if ($isUser !== false) {
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
            $userId = User::newUser($_POST['mailInput'], $_POST['lastnameInput'], $_POST['firstnameInput'], $cryptedPwd);
            
            // Creation d'un code pour l'envoie du mail de confirmation
            $code = AleatoryString();

            Confirmation::setupConfirmation($code, $userId, 'account');


            $mail = new Mail;
            $mail->sendMail(['mail' => $_POST['mailInput'], 'name' => $_POST['firstnameInput'].' '.$_POST['lastnameInput']], 'Merci de confirmer votre compte.', ['confirmationAccount', 'var' => $code]);
            
            
            $_SESSION['popup'] = new PopUp('success', 'Votre compte a bien été créé, mais il n\'est pas encore actif. Pour l\'activer, veuillez vérifier vos mail.');
            header('location: /AMOUV/inscription'); 
            exit;

        }
        

        View::render('Sign/SignUp', []);


    } // public function signUp()



    /**
     *  @name : validateAccount
     *  @param  void
     *  @return void
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
     *  @param  void
     *  @return void
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

            $_SESSION['popup'] = new PopUp('success', 'Vous êtes maintenant connecté');
            header('location: /AMOUV/');
            exit;

        }

        View::render('Sign/SignIn', []);


    } // public function signIn()



    /**
     *  @name : changePasswordMail
     * 
     *  @param void
     *  
     *  @return void
     * 
     *  @brief : User enter his mail to change his password
     */
    public function changePasswordMail() {

        if (isset($_POST['submit'])) {


            // mail
            if (empty($_POST['mailInput']) || !filter_var($_POST['mailInput'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['popup'] = new PopUp('error', 'Il faut saisir un mail valide.');
                header('location: /AMOUV/motdepasseoublie');      
                exit;
            }
            // Check if mail exists4
            $isUser = User::isMailExist($_POST['mailInput']);
            if (!$isUser) {
                $_SESSION['popup'] = new PopUp('error', 'L\'adresse mail renseigné est déja utilisé.');
                header('location: /AMOUV/motdepasseoublie');      
                exit;
            }
    
    
            // generate code confirm
            $code = AleatoryString();
    
            Confirmation::setupConfirmation($code, $isUser->getId(), 'password');
    
    
            $mail = new Mail;
            $mail->sendMail(['mail' => $_POST['mailInput'], 
                             'name' => 'Nom caché'], 
                             'Changer votre mot de passe.', 
                             ['changePwd', 'var' => $code]);

            $_SESSION['popup'] = new PopUp('success', 'Veuillez regarder vos mails afin de changer votre mot de passe.');

           
            header('location: /AMOUV/connexion');
            exit;
    
        }

        View::render('ChangePwd/changePwdFirst', []);

    } // public function changePwd()




    /**
     *  @name : changePassword
     * 
     *  @param void
     *  
     *  @return void
     * 
     *  @brief : Change password with code.
     *
     */
    public function changePassword() {
        
        if (!isset($_GET['code']) || strlen($_GET['code']) != 10) {
            $_SESSION['popup'] = new PopUp('error', 'Le code fourni est non valide');
            header('location: /AMOUV/inscription');      
            exit;
        }

        $isUser = Confirmation::isExist($_GET['code'], 'password');
        if (!$isUser) {
            $_SESSION['popup'] = new PopUp('error', 'Le code n\'existe pas !');
            header('location: /AMOUV/connexion');
            exit;
        }


        if (isset($_POST['submit'])) {
    
            if (!isset($_POST['passwordInput']) || !isset($_POST['RpasswordInput']) || $_POST['passwordInput'] != $_POST['RpasswordInput']) {
                $_SESSION['popup'] = new PopUp('error', 'Les mots de passe de correspondent pas.');
                header('location: /AMOUV/cpwdmail?code='.$_GET['code']);
                exit;
            }
    
    
            $cryptedPwd = password_hash($_POST['passwordInput'], PASSWORD_BCRYPT);

            // Changement de mdp
            User::setPassword($cryptedPwd, $isUser[0]['user_id']);
    
            // desactiver la confirmation
            Confirmation::disable($_GET['code']);
    
    
            $_SESSION['popup'] = new PopUp('success', 'Votre compte est maintenant actif, veuillez vous connecter !');
            header('location: /AMOUV/connexion');
            exit;

        }

        View::render('ChangePwd/changePwdSecond', []);



    } // public function changePassword()



    /**
     *  @name : signOut
     *  
     *  @param void
     *  
     *  @return void
     * 
     *  @brief : log out page controller
     */
    public function signOut() {
        unset($_SESSION['user']);
        
        $_SESSION['popup'] = new PopUp('success', 'Vous êtes maintenant déconnecté.');
        header('location: /AMOUV/');




    } // public function signOut()


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