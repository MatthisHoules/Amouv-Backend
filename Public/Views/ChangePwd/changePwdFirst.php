<?php
    if (isset($_SESSION['popup'])) {

        echo $_SESSION['popup']->display();
        unset($_SESSION['popup']);
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMOUV | mot de passe oublié</title>

    <link rel="stylesheet" href="./Public/assets/css/popup.css">
    <script src="./Public/assets/js/popup.js" defer></script>

    <link rel="stylesheet" href="./Public/assets/css/sign.css">
    <script src="./Public/assets/js/sign.js" defer></script>

    <script src="https://kit.fontawesome.com/b18ab37082.js" crossorigin="anonymous"></script>
</head>
<body id="preload">
    
    <main>
        <img src="./Public/assets/images/amouvLogoWhite.svg" alt="" class="signLogo">
        <a href="" class="backButton">
            <i class="fas fa-chevron-left"></i>
        </a>
        
        <form action="" method="POST">
            <p class="signTitle">
                Mot de passe oublié ?
            </p>

            <div class="inputContainer">
                <label for="mailInput">Adresse E-mail</label>
                <input type="email" name="mailInput" id="mailInput">
            </div>

            <div class="buttonContainer">
                <button type="submit" name="submit" value="submit">
                    Changer mon mot de passe
                </button>
            </div>

        </form>
    </main>





</body>
</html>