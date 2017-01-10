<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 12:55
 */

$error = '';
$dataOptimizme = json_decode($_POST['data_optme']);
$shop = $dataOptimizme->shop_name;

if (isset($dataOptimizme->action) && $dataOptimizme->action != ''){

    $shopifyObj = new ShopifyEasycontent($shop);

    ////////////////////////////
    // action to execute
    ////////////////////////////

    switch ($dataOptimizme->action){
        case 'get_products':                    $shopifyObj->getAllProducts(); break;
        case 'get_product':                     $shopifyObj->getProduct($dataOptimizme);
                                                $shopifyObj->getProductMetas($dataOptimizme);
                                                break;
        case 'update_product':                  $shopifyObj->saveProduct($dataOptimizme); break;

        case 'get_product_images':              $shopifyObj->getProductImages($dataOptimizme); break;
        case 'add_product_image_url':           $shopifyObj->addProductImage($dataOptimizme); break;
        case 'add_product_image_computer':      $shopifyObj->addProductImageComputer($dataOptimizme); break;
        case 'update_product_image_alt':        $shopifyObj->setProductImageAlt($dataOptimizme); break;
        case 'delete_product_image':            $shopifyObj->deleteProductImage($dataOptimizme); break;

        case 'get_redirections':                $shopifyObj->getAllRedirections(); break;
        case 'delete_redirection':              $shopifyObj->deleteRedirection($dataOptimizme); break;

        default :                               $error = 'no_action';
    }


    // response
    if ( is_array($shopifyObj->response) && count($shopifyObj->response)>0 ){

        // return
        $tabRetour = array('result' => 'success');
        if ($shopifyObj->message != '')     $tabRetour['message'] = $shopifyObj->message;

        if ( is_array($shopifyObj->response) && count($shopifyObj->response) >0){
            foreach ($shopifyObj->response as $key => $value){
                $tabRetour[$key] = $value;
            }
        }

        // all ok: send
        echo json_encode($tabRetour);

    }
    else {
        $error = 'no_response';
    }

}
else {
    $error = 'no_action';
}



/////////////////////
// here? not good
/////////////////////

if ($error != ''){
    echo json_encode(
        array(
            'result' => 'danger',
            'message' => 'Error doing Ajax for Shopify: '. $error
        )
    );
}

