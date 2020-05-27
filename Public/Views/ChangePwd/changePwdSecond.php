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
    <title>Document</title>

    <link rel="stylesheet" href="./Public/assets/css/popup.css">
    <script src="./Public/assets/js/popup.js" defer></script>

    
    <link rel="stylesheet" href="./Public/assets/css/sign.css">
    <script src="./Public/assets/js/sign.js" defer></script>

    <script src="https://kit.fontawesome.com/b18ab37082.js" crossorigin="anonymous"></script>
</head>
<body>
    
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
                <label for="passwordInput">Mot de passe</label>
                <div class="pwdInput">
                    <input type="password" name="passwordInput" id="passwordInput">
                    <button class="pwdTrigger" data-toggle="passwordInput" type="button">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="inputContainer">
                <label for="passwordInput">Répéter Mot de passe</label>
                <div class="pwdInput">
                    <input type="password" name="RpasswordInput" id="RpasswordInput">
                    <button class="pwdTrigger" data-toggle="RpasswordInput" type="button">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
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