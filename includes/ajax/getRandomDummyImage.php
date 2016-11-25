<?php
/**
 * Charge 3 images au hasard parmi le dossier images/dummy/
 */


$tabImages = array();
$files = scandir(IMG_DUMMY_PATH);
if (is_array($files) && count($files)>0){
    foreach ($files as $file){
        if ($file != '.' && $file != '..'){
            array_push($tabImages, IMG_DUMMY_URL . $file);
        }
    }
}

// randomize
shuffle($tabImages);

// 3 premières images
$tabImages = array_slice($tabImages, 0, 3);

// retour
echo json_encode(
    array(
        'result' => 'success',
        'images' => $tabImages
    )
);