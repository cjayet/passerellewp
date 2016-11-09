<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 07/11/2016
 * Time: 13:35
 */

/**
 * @param $s
 */
function nice($s){
    echo '<pre>';print_r($s);echo '</pre>';
}

/**
 * Lancement du script d'installation du plugin Phantomjs
 */
function executeInstall(){
    // config
    set_time_limit(90);
    $pathBinary = 'D:\phantomjs\phantomjs.exe';
    $pathScript = 'js/phantom-automation.js';
    $login = $_POST['login'];
    $password = $_POST['password'];
    $urlBackoffice = $_POST['url_backoffice'];

    // call install script
    $response = exec($pathBinary .' '.  $pathScript .' '. $login .' '. $password .' '. $urlBackoffice);
    return $response;
}