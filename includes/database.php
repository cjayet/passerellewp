<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 12:20
 */

class EasycontentDB {

    public $dbh;

    public function __construct()
    {
        try {
            $this->dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME , DB_USER, DB_PASS);
        }
        catch (Exception $e){
            echo "Erreur connexion : " . $e->getMessage();
        }
    }

}