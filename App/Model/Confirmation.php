<?php

/**
 *  @title : Confirmation.php
 * 
 *  @author : Guillaume RISCH
 *  @author : Théo MOUMDJIAN
 *  @refractor : Matthis HOULES
 * 
 *  @brief : user confirmations (change pwd, account creation) class
 * 
 */

class Confirmation extends Model {



    /**
     *  @name : setupConfirmation
     * 
     *  @param  : code : string
     *  @param : user id int
     *  @param  : use : string
     * 
     *  @return : void  
     * 
     *  @brief : insert in database
     */
    public static function setupConfirmation($code, $userId, $use) {

        $DB = static::DBConnect();
        $stmt = $DB->prepare('INSERT INTO `confirmation` (`id`, `code`, `user_id`, `use_for`, `active`) 
                              VALUES (NULL, ?, ?, ?, 1)');
        $stmt->execute([$code, $userId, $use]);

        return;


    } // public static function setupConfirmation($code, $userId, $use)



    /**
     * 
     *  @name : isExist
     *  @param : code : string
     *  @param : use : string : what the confirmation is use for (account, password..)
     *  
     *  @return boolean false if don't exist or already confirmed, true instead
     * 
     */
    public static function isExist($code, $use) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('SELECT * 
                              FROM `confirmation` 
                              WHERE `code` = ?
                                AND `use_for` = ?
                                AND `active` = 1 ');

        $stmt->execute([$code, $use]);

        $result = $stmt->fetchAll();

        if (sizeof($result) == 0) {
            return false;
        }
        return $result;

    } // public static function isConfirmationExist($code)



    /**
     * 
     *  @name : disable
     *  @param : code : string
     *  
     *  @return : void
     * 
     *  @brief : disable confirmation
     */
    public static function disable($code) {

        $DB = static::DBConnect();

        $stmt = $DB->prepare('UPDATE `confirmation` 
                  SET `active` = \'0\' 
                  WHERE `confirmation`.`code` = ?');

        $stmt->execute([$code]);

        return;

    } // public static function disable($code)

}




?>