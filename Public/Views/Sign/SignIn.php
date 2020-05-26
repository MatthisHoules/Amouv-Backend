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
    <title>Amouv | connexion</title>

    <link rel="stylesheet" href="./Public/assets/css/popup.css">
    <script src="./Public/assets/js/popup.js" defer></script>

    <link rel="stylesheet" href="./Public/assets/css/sign.css">
    <script src="./Public/assets/js/sign.js" defer></script>

    <script src="https://kit.fontawesome.com/b18ab37082.js" crossorigin="anonymous"></script>
</head>
<body>
    
<img src="./Public/assets/images/amouvLogoBlack.svg" alt="" class="signLogo">
    <main>
        <a href="" class="backButton">
            <i class="fas fa-chevron-left"></i>
        </a>
        
        <form action="" method="POST">
            <p class="signTitle">
                Connectez-vous
            </p>

            <div class="inputContainer">
                <label for="mailInput">Adresse E-mail</label>
                <input type="email" name="mailInput" id="mailInput">
            </div>

            <div class="inputContainer">
                <label for="pwdInput">Mot de passe</label>
                <div class="pwdInput">
                    <input type="password" name="pwdInput" id="pwdInput">
                    <button class="pwdTrigger" data-toggle="pwdInput" type="button">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="buttonContainer">
                <button type="submit" name="submit" value="submit">
                    Connexion
                </button>
            </div>

        </form>
    </main>


</body>
</html>