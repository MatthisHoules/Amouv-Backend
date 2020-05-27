<?php
    if (isset($_SESSION['popup'])) {

        echo $_SESSION['popup']->display();
        unset($_SESSION['popup']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Amouv | template guest</title>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/b18ab37082.js" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="./Public/assets/css/template.css">

    <link rel="stylesheet" href="./Public/assets/css/popup.css">
    <script src="./Public/assets/js/popup.js" defer></script>
    
    <?php foreach ($listStyles as $key => $value) { ?>
        <link rel="stylesheet" href="./Public/assets/css/<?=$value?>">
    <?php } ?>

    <!-- JS -->
    <script src="./Public/assets/js/templateGuest.js"></script>

    <?php foreach ($listStyles as $key => $value) { ?>
        <script src="./Public/assets/js/<?= $value ?>" defer></script>

        <link rel="stylesheet" href="./Public/assets/css/template.css">
    <?php } ?>
</head>



<body id="body" class="preload">
    <div class="navbarOverlay" id="navbarOverlay">
    </div>
    
    <div class="sideBar" id="sideBar">
        <button id="closeSideBarB">
            <i class="fas fa-times"></i>
        </button>
        <div class="topSidebar">
            <p class="mainTitle">
                Bienvenue
            </p>
            <p class="secondTitle">
                Vous devez être connecter pour accéder aux fonctionnalités du site web.
            </p>
    
            <button class="sideLink">
                <i class="fas fa-sign-in-alt"></i>
                <span>
                    Se connecter
                </span>
            </button>
            <button class="sideLink">
                <i class="fas fa-user-plus"></i>
                <span>
                    S'inscrire
                </span>
            </button>
        </div>
    
        <nav class="nbSideBar">
            <div class="linkContainer">
                <p class="linktitle">
                    Autres
                </p>
                <a class="sideLink">
                    <i class="far fa-copyright"></i>
                    <span>
                        Crédits
                    </span>
                </a>
            </div>
        </nav>
    </div>
    <header>
        <div class="headerContent">
    
            <img src="./Public/assets/images/amouvLogoBlack.svg" alt="AmouvLogo" class="logoHeader">
    
    
            <div class="headerTriggersContainer">
                <div class="signContainer">
                    
                    <button class="signButton signInButton">
                        <i class="fas fa-sign-in-alt"></i>
                        Se connecter
                    </button>
    
                    <button class="signButton signUpButton">
                        <i class="fas fa-user-plus"></i>
                        S'inscrire
                    </button>
                </div>
    
                <button class="menuTrigger" id="menuTrigger">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <?= $content ?>
    

    <footer>
        <img src="./Public/assets/images/amouvLogoWhite.svg" alt="AmouvLogo" class="footerLogo">
        <div class="snContainer">
            <a href="" class="socialNetwork">
                <i class="fab fa-twitter-square"></i>
            </a>
            <a href="" class="socialNetwork">
                <i class="fab fa-facebook-square"></i>
            </a>
            <a href="" class="socialNetwork">
                <i class="fab fa-instagram-square"></i>
            </a>
        </div>
    </footer>
</body>
</html>