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

    public function __construct($shopName=''){
        $this->loadAppData();
        if ($shopName!= '')         $this->loadShopConnection($shopName);
    }

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
    }

    /**
     * @param $shop
     * @return string
     */
    public function getAccessTokenByShopName($shop){
        $sql = 'SELECT access_token FROM shopify_usersettings WHERE store_name="'. $shop .'" LIMIT 1';
        $db = new EasycontentDB();
        foreach ($db->dbh->query($sql) as $row){
            return $row['access_token'];
        }
        return '';
    }

    /**
     * @return mixed
     */
    public function getAllProducts(){

        $shopify = $this->shopify;

        /*$args = array(
            "product" => array (
                "title" => "Burton Custom Freestyle 151",
                "body_html" => "test",
                "vendor" => "Burton",
                "product_type" => "Snowboard",
                "metafield" => array(
                    "key" => "new",
                    "value" => "newvalue",
                    "value_type" => "string",
                    "namespace" => "global"
                )
            )
        );

        $products = $shopify('POST', '/admin/products.json', $args);
        echo "fin";
        die;
        */


        // update product
        /*
        $args = array(
            'image' => array(
                'id' => 19917573197,
                'position' => 2,
                'metafields' => array(
                    "key" => "alt",
                    "value" => 'TEST ALT',
                    "value_type" => "string",
                    "namespace" => "tags"
                )
            )
        );

        $image = $shopify('PUT', '/admin/products/8590696909/images/19917573197.json', $args);
*/


        /*
        $args = array(
            'metafield' => array(
                'key' => 'alt',
                'value' => 'NEW ALT',
                'value_type' => 'string',
                'namespace' => 'tags'
            )
        );
        $shopify('POST', '/admin/products/8590696909/images/19917573197/metafields.json', $args);
*/



        /*
        // product image
        $args2 = array (
            "image" =>  array(
                "id" => 19917573197,
                "position" => 2,
                "metafields" => array(
                     array(
                        "key"=> "alt",
                        "value"=> "PUSH3",
                        "value_type"=> "string",
                        "namespace"=> "tags"
                    )
                )

            )
        );

        $t = $shopify('PUT', '/admin/products/8590696909/images/19917573197.json', $args2);
*/

        /*

        $args3 = array(
            "product" => array(
                "title" => "Basket of Kittens ". time(),
                "product_type"=> "Basket",
                "images" => array(
                    "position" => 1,
                    "src" => "http://cdn.shopify.com/s/files/1/0572/9965/products/Basket-of-kittens.jpg",
                    "metafields" => array(
                        "namespace" => "tags",
                        "key" => "alt",
                        "value" => "basket of kittens",
                        "value_type" => "string"
                    )
                )
            )
        );

        $shopify('POST', '/admin/products.json ', $args3);


        */




        $products = $shopify('GET', '/admin/products.json', array('published_status' => 'published'));
        return $products;
    }

    /**
     * @param $idProduct
     * @return mixed
     */
    public function getProduct($idProduct){
        $shopify = $this->shopify;
        $product = $shopify('GET', '/admin/products/'. $idProduct .'.json');
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
        return $product;
    }

    /**
     * @param $idProduct
     * @return array
     */
    public function getProductMetas($idProduct){
        $shopify = $this->shopify;
        $metaProduct = $shopify('GET', '/admin/products/'. $idProduct .'/metafields.json');
        $productMeta = array('meta_title' => '', 'meta_description' => '');
        if (is_array($metaProduct) && count($metaProduct)>0){
            foreach ($metaProduct as $metaBoucle){
                if ($metaBoucle['key'] == 'description_tag')        $productMeta['meta_description'] = $metaBoucle['value'];
                if ($metaBoucle['key'] == 'title_tag')              $productMeta['meta_title'] = $metaBoucle['value'];
            }
        }
        return $productMeta;
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
                'body_html' => preg_replace( "/\r|\n/", "", ($data->new_description)),
                'handle' => $data->handle
            )
        );
        $product = $shopify('PUT', '/admin/products/'. $data->id_post .'.json', $args);


        // creation d'une redirection (si url a changé)
        if ( isset($data->handle) && $data->handle != '' && isset($data->current_handle) && $data->current_handle != $data->handle){
            // handles différents: ajour d'une redirection
            $argsRedirect = array('redirect' => array('path' => '/products/'. $data->current_handle, 'target' => '/products/'. $data->handle));
            $redirection = $shopify('POST', '/admin/redirects.json', $argsRedirect);
        }
    }

    /**
     * @return mixed
     */
    public function getAllRedirections(){
        $shopify = $this->shopify;
        $redirections = $shopify('GET', '/admin/redirects.json');
        return $redirections;
    }


    /**
     * @param $idRedirection
     */
    public function deleteRedirection($idRedirection){
        $shopify = $this->shopify;
        $res = $shopify('DELETE', '/admin/redirects/'. $idRedirection .'.json');
    }


    /**
     * @param $idProduct
     * @param $idImage
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
        $shopify('PUT', '/admin/products/'. $dataOptimizme->id_post .'/images/'. $dataOptimizme->id_image .'.json', $args);
    }


    /**
     * @param $dataOptimizme
     * @return int|string
     */
    public function addProductImage($dataOptimizme){

        $shopify = $this->shopify;

        try {
            $args = array(
                "image" => array(
                    //"src" => "http:\/\/example.com\/rails_logo.gif"
                    //"src" => "http:\/\/www.w3schools.com\/css\/img_fjords.jpg",
                    "src" => $dataOptimizme->url,
                    "metafields" => array(
                        0 => array(
                            "key"=> "alt",
                            "value"=> $dataOptimizme->image_alt,
                            "value_type"=> "string",
                            "namespace"=> "tags"
                        )
                    )
                )
            );

            $rest = $shopify('POST', '/admin/products/'. $dataOptimizme->id_post .'/images.json', $args);
            if ($rest['src']){
                return 1;
            }
            else {
                return "Error";
            }

        }
        catch (Exception $e){
            return $e->getMessage();
        }

    }


    /**
     * @param $dataOptimizme
     * @return int
     */
    public function deleteProductImage($dataOptimizme){
        $shopify = $this->shopify;
        try {
            $shopify('DELETE', '/admin/products/' . $dataOptimizme->id_post . '/images/' . $dataOptimizme->id_image . '.json');
            return 1;
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }
}