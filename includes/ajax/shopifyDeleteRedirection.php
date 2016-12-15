<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 12:55
 */

$dataOptimizme = json_decode($_POST['data_optme']);
$shop = $dataOptimizme->shop_name;
$idRedirection = $dataOptimizme->id_redirection;

$shopObj = new ShopifyEasycontent($shop);
$redirection = $shopObj->deleteRedirection($idRedirection);

echo json_encode(
    array(
        'result' => 'success',
        'redirection' => $redirection
    )
);
