<?php
/**
 * Return Lorem Ipsum
 */
$nbParagraphes = rand(2,4);
$content = file_get_contents('http://loripsum.net/api/'.$nbParagraphes.'/short/decorate/');
echo json_encode(
    array(
        'result' => 'success',
        'lorem' => $content,
        )
);
