<?php
// récupération des données
$dataOptimizme = json_decode($_POST['data_optme']);

// load nodes
$tabImages = array();
$doc = new DOMDocument;
$nodes = OptimizmeUtils::getNodesInDom($doc, 'img', $dataOptimizme->grideditor_content);
if ($nodes->length > 0){
    foreach ($nodes as $node) {
        array_push($tabImages,
            array(
                'src' => $node->getAttribute('src'),
                'alt' => utf8_decode($node->getAttribute('alt')),
                'title' => utf8_decode($node->getAttribute('title'))
            ));
    }
}

echo json_encode(
    array(
        'result' => 'success',
        'images' => $tabImages
    )
);

