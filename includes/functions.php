<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 07/11/2016
 * Time: 13:35
 */

class OptimizmeUtils {

    /**
     * Chargement d'une page
     * @param $p
     */
    public static function LoadPage($p){
        if ( isset($p) && $p != '')     $pageLoad = $p;
        else                            $pageLoad = 'home';

        include ('views/pages/'. $p. '.php');
    }

    /**
     * Chargement d'un bloc de contenu
     * @param $b
     */
    public static function LoadBloc($b, $ext='php'){
        if ( isset($b) && $b != ''){
            include ('views/blocs/'. $b. '.'. $ext);
        }
    }

    /**
     * Lien vers une page donnée
     * @param $p
     */
    public static function LinkToPage($p){
        echo 'index.php?page='. $p;
    }

    public static function ExecuteAjax($action){
        include ('includes/ajax/'. $action. '.php');
    }


    /**
     * Affichage sympa
     * @param $s
     */
    public static function nice($s){
        echo '<pre>';print_r($s);echo '</pre>';
    }

    /**
     * Lancement du script d'installation du plugin Phantomjs
     */
    public static function executeInstall(){
        // config
        set_time_limit(90);
        $login = $_POST['login'];
        $password = $_POST['password'];
        $urlBackoffice = $_POST['url_backoffice'];

        // call install script
        $response = exec(PHANTOMJS_PATH_BINARY .' '.  PHANTOMJS_RELATIVE_PATH_SCRIPT .' '. $login .' '. $password .' '. $urlBackoffice);
        return $response;
    }


    /**
     * @param $s
     * @return string
     */
    public static function getRelatedContentFromText($s){
        // TODO vraie recherche

        $nbParagraphes = rand(2,4);
        $content = file_get_contents('http://loripsum.net/api/'.$nbParagraphes.'/short/decorate/');
        return $content;
    }



    /**
     * Get Dom from html
     *  and add a "<span>" tag in top
     * @param $doc
     * @param $tag
     * @param $content
     * @return DOMNodeList
     */
    public static function getNodesInDom($doc, $tag, $content){

        // load post content in DOM
        libxml_use_internal_errors(true);
        $doc->loadHTML('<span>'.$content.'</span>');
        libxml_clear_errors();

        // get all images in post content
        $xp = new DOMXPath($doc);
        $nodes = $xp->query('//'.$tag);
        return $nodes;
    }
}
