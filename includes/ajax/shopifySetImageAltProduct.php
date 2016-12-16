<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 12:55
 */

$dataOptimizme = json_decode($_POST['data_optme']);

$shop = $dataOptimizme->shop_name;
$idProduct = $dataOptimizme->id_post;
$idImage = $dataOptimizme->id_image;
$alt = $dataOptimizme->alt_image;

$shopObj = new ShopifyEasycontent($shop);
$image = $shopObj->setProductImageAlt($dataOptimizme);


echo json_encode(
    array(
        'result' => 'success',
        'image' => $image,
        'message' => 'Image updated',
    )
);
