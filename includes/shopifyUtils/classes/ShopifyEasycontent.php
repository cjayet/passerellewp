<?php
require 'includes/shopifyUtils/vendor/autoload.php';
use sandeepshetty\shopify_api;

/**
 * Created by PhpStorm.
 * User: clement
 * Date: 14/12/2016
 * Time: 11:53
 */
class ShopifyEasycontent
{
    public $shopify;

    public function __construct($shopName){
        $this->loadShopConnection($shopName);
    }


    /**
     * @param $shopName
     * @return Closure
     */
    public function loadShopConnection($shopName){

        $db = new EasycontentDB();
        $appSettings = $db->getOneRow('SELECT * FROM tbl_appsettings WHERE id="1"');

        $token = $this->getAccessTokenByShopName($shopName);
        if ($token != ''){
            $shopify = shopify_api\client(
                $shopName, $token, $appSettings->api_key, $appSettings->shared_secret
            );
            $this->shopify = $shopify;
        }
    }

    /**
     * @param $shop
     * @return string
     */
    public function getAccessTokenByShopName($shop){
        $sql = 'SELECT access_token FROM tbl_usersettings WHERE store_name="'. $shop .'" LIMIT 1';
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
    public function setProductImageAlt($idProduct, $idImage){
        $shopify = $this->shopify;

        // update product
        $args = array(
            'image' => array(
                'metafields' => array(
                    "key" => "alt",
                    "value" => "new alt tag content",
                    "value_type" => "string",
                    "namespace" => "tags"
                )
            )
        );
        $product = $shopify('PUT', '/admin/products/'. $idProduct .'/images/'. $idImage .'.json', $args);
    }

}