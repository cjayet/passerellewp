<?php
// récupération des données
$dataOptimizme = json_decode($_POST['data_optme']);

// load nodes
$tabLiens = array();
$doc = new DOMDocument;
$nodes = OptimizmeUtils::getNodesInDom($doc, 'a', $dataOptimizme->grideditor_content);
if ($nodes->length > 0){
    foreach ($nodes as $node) {
        array_push($tabLiens,
            array(
                'href' => $node->getAttribute('href'),
                'rel' => $node->getAttribute('rel'),
                'target' => $node->getAttribute('target')
            ));
    }
}

// retour
echo json_encode(
    array(
        'result' => 'success',
        'liens' => $tabLiens
    )
);

