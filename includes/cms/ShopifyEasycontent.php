<?php
use sandeepshetty\shopify_api;

/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 11:53
 */
class ShopifyEasycontent
{
    public $appSettings;
    public $shopify;
    public $response;
    public $message;

    /**
     * ShopifyEasycontent constructor.
     * @param string $shopName
     */
    public function __construct($shopName=''){
        $this->message = '';
        $this->response = array();

        $this->loadAppData();
        if ($shopName!= '')         $this->loadShopConnection($shopName);
    }

    /**
     * load app data for shopify
     */
    public function loadAppData(){
        $db = new EasycontentDB();
        $this->appSettings = $db->getOneRow('SELECT * FROM shopify_appsettings WHERE id="1"');
    }

    /**
     * @param $shopName
     * @return Closure
     */
    public function loadShopConnection($shopName){

        $token = $this->getAccessTokenByShopName($shopName);
        if ($token != ''){
            $shopify = shopify_api\client(
                $shopName, $token, $this->appSettings->api_key, $this->appSettings->shared_secret
            );
            $this->shopify = $shopify;
        }

        else {
            // erreur connexion
            echo json_encode( array('result' => 'Erreur', 'message' => 'Erreur de connexion à la boutique : is credentials in database ?'));
            die;
        }
    }

    /**
     * @param $shop
     * @return string
     */
    public function getAccessTokenByShopName($shop){
        $sql = 'SELECT access_token FROM shopify_usersettings WHERE store_name="'. $shop .'" LIMIT 1';
        $db = new EasycontentDB();

        try {
            $stmt = $db->dbh->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row['access_token'];
        }
        catch (Exception $e){
            return '';
        }
        return '';
    }

    /**
     * @return mixed
     */
    public function getAllProducts(){

        $shopify = $this->shopify;
        try {
            $this->response['products'] = $shopify('GET', '/admin/products.json', array('published_status' => 'published'));
        }
        catch (Exception $e){
            $this->message = 'Error get products: '. $e->getMessage();
        }

    }

    /**
     * @param $data
     */
    public function getProduct($data){
        $shopify = $this->shopify;

        try {
            $product = $shopify('GET', '/admin/products/'. $data->id_product .'.json');

            if (is_array($product['images']) && count($product['images'])>0){
                for ($i=0; $i<count($product['images']);$i++){

                    // charge metafields de cette image
                    $metafields = $shopify('GET', '/admin/metafields.json?metafield[owner_id]='. $product['images'][$i]['id'] .'&metafield[owner_resource]=product_image');
                    //OptimizmeUtils::nice($metafields);
                    if (is_array($metafields) && count($metafields)>0){
                        foreach ($metafields as $metafieldBoucle){
                            $product['images'][$i]['metafield_'. $metafieldBoucle['key']] = $metafieldBoucle['value'];
                            $product['images'][$i]['metafield_'. $metafieldBoucle['key'].'_id'] = $metafieldBoucle['id'];
                        }
                    }

                    // ajoute le champ "alt" dans l'image si rien n'est défini
                    if ( !isset($product['images'][$i]['metafield_alt']) ){
                        $product['images'][$i]['metafield_alt'] = '';
                        $product['images'][$i]['metafield_alt_id'] = '';
                    }
                }
            }

            $this->response['product'] = $product;

        }
        catch (Exception $e){
            $this->message = 'Error get product: '. $e->getMessage();
        }
    }

    /**
     * @param $data
     */
    public function getProductMetas($data){
        $shopify = $this->shopify;

        try {
            $metaProduct = $shopify('GET', '/admin/products/'. $data->id_product .'/metafields.json');
            $productMeta = array('meta_title' => '', 'meta_description' => '');
            if (is_array($metaProduct) && count($metaProduct)>0){
                foreach ($metaProduct as $metaBoucle){
                    if ($metaBoucle['key'] == 'description_tag')        $productMeta['meta_description'] = $metaBoucle['value'];
                    if ($metaBoucle['key'] == 'title_tag')              $productMeta['meta_title'] = $metaBoucle['value'];
                }
            }
            $this->response['metas'] = $productMeta;
        }
        catch (Exception $e){
            $this->message = 'Error get product meta: '. $e->getMessage();
        }

    }

    /**
     * @param $data
     */
    public function saveProduct($data){
        $shopify = $this->shopify;

        // update product
        $args = array(
            'product' => array(
                'id' => $data->id_post,
                'title' => $data->name,
                'metafields_global_title_tag' => $data->metatitle,
                'metafields_global_description_tag' => $data->metadescription,
                'body_html' => preg_replace( "/\r|\n/", "", ($data->product_description)),
                'handle' => $data->handle
            )
        );

        try {
            $product = $shopify('PUT', '/admin/products/'. $data->id_post .'.json', $args);

            if ( isset($data->handle) && $data->handle != '' && isset($data->current_handle) && $data->current_handle != $data->handle){
                // handles différents: ajour d'une redirection
                $argsRedirect = array('redirect' => array('path' => '/products/'. $data->current_handle, 'target' => '/products/'. $data->handle));
                $product = $shopify('POST', '/admin/redirects.json', $argsRedirect);
                $this->message = 'Product saved and redirection added';
            }
            else {
                $this->message = 'Product saved';
            }

            $this->response['product'] = $product;

        }
        catch (Exception $e){
            $this->message = 'Error save product: '. $e->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public function getAllRedirections(){
        $shopify = $this->shopify;

        try {
            $redirections = $shopify('GET', '/admin/redirects.json');
            $this->response['redirections'] = $redirections;
        }
        catch (Exception $e){
            $this->message = 'Error get all redirection: '. $e->getMessage();
        }

    }

    /**
     * @param $idRedirection
     */
    public function deleteRedirection($data){
        $shopify = $this->shopify;
        try {
            $shopify('DELETE', '/admin/redirects/'. $data->id_redirection .'.json');
            $this->response['delete'] = 1;
            $this->message = 'Redirect deleted';
        }
        catch (Exception $e){
            $this->message = 'Error delete redirection: '. $e->getMessage();
        }
    }

    /**
     * @param $dataOptimizme
     */
    public function setProductImageAlt($dataOptimizme){

        $shopify = $this->shopify;

        if ($dataOptimizme->id_metafield_alt != ''){
            // already exists: delete
            $shopify('DELETE', '/admin/products/'. $dataOptimizme->id_post .'/metafields/'. $dataOptimizme->id_metafield_alt .'.json');
        }

        // create metafield
        $args = array (
            "image" =>  array(
                "id" => $dataOptimizme->id_image ,
                "metafields" => array(
                    array(
                        "key"=> "alt",
                        "value"=> $dataOptimizme->alt_image,
                        "value_type"=> "string",
                        "namespace"=> "tags"
                    )
                )
            )
        );

        try {
            $image = $shopify('PUT', '/admin/products/'. $dataOptimizme->id_post .'/images/'. $dataOptimizme->id_image .'.json', $args);
            $this->response['image'] = $image;
            $this->message = 'Image Alt updated';
        }
        catch (Exception $e){
            $this->message = 'Error set product image alt';
        }
    }

    /**
     * @param $dataOptimizme
     */
    public function addProductImage($dataOptimizme){

        $shopify = $this->shopify;

        try {
            $args = array(
                "image" => array(
                    "src" => $dataOptimizme->url
                )
            );

            $rest = $shopify('POST', '/admin/products/'. $dataOptimizme->id_post .'/images.json', $args);
            if ($rest['src']){
                $this->response['image'] = $rest;
                $this->message = 'Image added';
            }
            else {
                $this->message = 'Error, no source for image';
            }

        }
        catch (Exception $e){
            $this->message = 'Error add product image from url: '. $e->getMessage();
        }
    }

    /**
     * @param $dataOptimizme
     */
    public function addProductImageComputer($dataOptimizme){

        $shopify = $this->shopify;

        if (is_array($dataOptimizme->files) && count($dataOptimizme->files)>0){
            foreach ($dataOptimizme->files as $fileImage){
                try {
                    $args = array(
                        "image" => array(
                            "attachment" => OptimizmeUtils::removeBase64Metadata($fileImage->content),
                            "filename" => $fileImage->name
                        )
                    );

                    $rest = $shopify('POST', '/admin/products/'. $dataOptimizme->id_post .'/images.json', $args);
                    if (!$rest['src']){
                        $this->message = 'Error adding image;';
                    }
                }
                catch (Exception $e){
                    $this->message = 'Error add product image form computer: '. $e->getMessage();
                }
            }

            // all ok
            $this->response['add'] = 1;
            $this->message = 'Image(s) added';
        }
    }

    /**
     * @param $dataOptimizme
     */
    public function deleteProductImage($dataOptimizme){
        $shopify = $this->shopify;
        try {
            $shopify('DELETE', '/admin/products/' . $dataOptimizme->id_post . '/images/' . $dataOptimizme->id_image . '.json');
            $this->response['delete'] = 1;
            $this->message = 'Product image deleted';
        }
        catch (Exception $e){
            $this->message = "Error delete product image: ". $e->getMessage();
        }
    }
}