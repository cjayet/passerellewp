<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 12:55
 */
error_reporting(0);

$dataOptimizme = json_decode($_POST['data_optme']);
$shop = $dataOptimizme->shop_name;

$shopObj = new ShopifyEasycontent($shop);
$resImg = $shopObj->addProductImage($dataOptimizme);

if ($resImg == 1){
    $res = array(
        'result' => 'success',
        'message' => 'Image ajoutée'
    );
}
else {
    $res = array(
        'result' => 'danger',
        'message' => 'Erreur : '. $resImg
    );
}

echo json_encode($res);
