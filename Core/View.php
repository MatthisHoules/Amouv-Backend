<?php
/**
 *  @title : View.php
 *  @author : Guillaume RISCH
 *  @author : Matthis HOULES
 * 
 *  @brief : View render
 */


class View {

    public static function render($viewPage, $args = []) {
        // create var with args
        // args key = var name & args value = var value
        foreach ($args as $key => $value) {
            $$key = $value;
        }


        if (!file_exists(__DIR__.'/../Public/Views/'. $viewPage .'.php')) {
            var_dump('Erreur : La vue recherchée n\'existe pas.');
            die();

        }

        require_once(__DIR__.'/../Public/Views/' . $viewPage .'.php');

    }



}