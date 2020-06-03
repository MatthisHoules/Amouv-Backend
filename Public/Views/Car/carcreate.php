<?php

/**
 * 
 *  @title : carCreate.php
 *  @author : Guillaume Risch
 *  @author : Matthis HOULES
 * 
 *  @brief : carCreate view
 * 
 */


?>


<html>
    <head>
        <title>carCreate view</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div align="center">
            <h2>Inscription de votre voiture</h2>
            <form method="POST" action="">
                <table>
                    <tr>
                        <td align="right">
                            <label for="Voiture">
                                Voiture :</label>
                        </td>
                        <td align="right">
                            <input type="text" placeholder="Modèle de voiture" name="Voiture"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="Couleur">
                            Couleur :</label>
                        </td>
                        <td align="right">
                            <input type="text" placeholder="Couleur de la voiture" name="Couleur"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="Places">
                            Places :</label>
                        </td>
                        <td align="right">
                            <input type="text" placeholder="Nombres de places" name="Places"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <label for="Motorisation">
                            Motorisation :</label>
                        </td>
                        <td align="right">
                            <input type="text" placeholder="Motorisation" name="Essence/Diesel/Electrique/Etc.. "/>
                        </td>
                    </tr>
                </table>
                <input type="submit" name="formcar" value="Valider l'inscription de la voiture" />
            </form>
        </div>
    </body>
</html>

