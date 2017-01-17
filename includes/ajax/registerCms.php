<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 17/01/2017
 * Time: 14:19
 */

// database connect
$db = new EasycontentDB();
$error = '';

$dataOptimizme = json_decode($_POST['data_optme']);

if (is_object($dataOptimizme)){
   try {
       // register site
       $db->registerCmsToEasycontent($dataOptimizme);
       $tabRetour = array('result' => 'success');
       echo json_encode($tabRetour);
   }
   catch (Exception $e){
       $error = 'Error adding CMS in EasyContent:'. $e->getMessage();
   }
}
else {
    $error = 'No data send';
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