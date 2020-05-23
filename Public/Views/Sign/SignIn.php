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

    <script src="https://kit.fontawesome.com/b18ab37082.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <form action="" method="post">
        
        <input type="email" name="mailInput" id="">
        <input type="password" name="pwdInput" id="">
        <input type="submit" value="connexion" name="submit">
    </form>

</body>
</html>