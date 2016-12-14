<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 12:55
 */

$dataOptimizme = json_decode($_POST['data_optme']);
$shop = $dataOptimizme->shop_name;
$idProduct = $dataOptimizme->id_product;

$shopObj = new ShopifyEasycontent();
$shopify = $shopObj->loadShopConnection($shop);
$product = ShopifyEasycontent::getProduct($shopify, $idProduct);
$metas = ShopifyEasycontent::getProductMetas($shopify, $idProduct);

echo json_encode(
    array(
        'result' => 'success',
        'product' => $product,
        'metas' => $metas
    )
);
