<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 12:55
 */

$dataOptimizme = json_decode($_POST['data_optme']);
$shop = $dataOptimizme->shop_name;

$shopObj = new ShopifyEasycontent($shop);
$products = $shopObj->getAllProducts();

echo json_encode(
    array(
        'result' => 'success',
        'products' => $products
    )
);