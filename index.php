<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 25/11/2016
 * Time: 11:35
 */

session_start();
$_SESSION['id_optimizme_user'] = 3; // TODO vraie gestion de session utilisateur

// load
require_once ('includes/constantes.php');
require_once ('includes/functions.php');

// controller
if (isset($_GET['ajax']) && $_GET['ajax'] != ''){
    OptimizmeUtils::ExecuteAjax($_GET['ajax']);

}
elseif (isset($_GET['page']) && $_GET['page'] != ''){
    OptimizmeUtils::LoadPage($_GET['page']);
}
else {
    OptimizmeUtils::LoadPage('home');
}