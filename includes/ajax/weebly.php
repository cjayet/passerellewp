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

    $weebly = new WeeblyEasycontent($dataOptimizme->shop_name);

    ////////////////////////////
    // action to execute
    ////////////////////////////

    switch ($dataOptimizme->action){
        case 'get_products':            $weebly->getProducts(); break;
        case 'get_product':             $weebly->getProduct($dataOptimizme); break;
        case 'update_product':           $weebly->patchProduct($dataOptimizme); break;
        case 'get_product_images':      $weebly->getProductImages($dataOptimizme); break;
        case 'delete_product_image':    $weebly->deleteProductImage($dataOptimizme); break;
        case 'add_product_image_url':   $weebly->addProductImageFromUrl($dataOptimizme); break;

        //case 'add_product_image_computer':   $weebly->($dataOptimizme); break;
        //case 'delete_product_image':   $weebly->($dataOptimizme); break;

        default :               $error = 'no_action';
    }


    // response
    if ( is_array($weebly->response) && count($weebly->response)>0 ){

        // return
        $tabRetour = array('result' => 'success');
        if ($weebly->message != '')     $tabRetour['message'] = $weebly->message;

        if ( is_array($weebly->response) && count($weebly->response) >0){
            foreach ($weebly->response as $key => $value){
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
            'message' => 'Error doing Ajax for Weebly: '. $error
        )
    );
}

