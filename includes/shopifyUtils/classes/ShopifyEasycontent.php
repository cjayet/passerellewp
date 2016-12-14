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
    /**
     * @param $shopName
     * @return Closure
     */
    public function loadShopConnection($shopName){

        $token = $this->getAccessTokenByShopName($shopName);
        if ($token != ''){
            $shopify = shopify_api\client(
                $shopName, $token, SHOPIFY_API_KEY, SHOPIFY_SHARED_SECRET    // TODO cle site client
            );
            return $shopify;
        }
    }

    /**
     * @param $shop
     * @return string
     */
    public function getAccessTokenByShopName($shop){
        $sql = 'SELECT access_token FROM tbl_usersettings WHERE store_name="'. $shop .'" LIMIT 0, 1';
        $db = new EasycontentDB();
        foreach ($db->dbh->query($sql) as $row){
            return $row['access_token'];
        }
        return '';
    }

    /**
     * @param $shopify
     * @return mixed
     */
    public static function getAllProducts($shopify){
        $products = $shopify('GET', '/admin/products.json', array('published_status' => 'published'));
        return $products;
    }

    /**
     * @param $shopify
     * @param $idProduct
     * @return mixed
     */
    public static function getProduct($shopify, $idProduct){
        $product = $shopify('GET', '/admin/products/'. $idProduct .'.json');
        return $product;
    }

    /**
     * @param $shopify
     * @param $idProduct
     * @return mixed
     */
    public static function getProductMetas($shopify, $idProduct){
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

    public static function saveProduct($shopify, $data){

        // update product
        $args = array(
            'product' => array(
                'id' => $data->id_post,
                'title' => $data->name,
                'metafields_global_title_tag' => $data->metatitle,
                'metafields_global_description_tag' => $data->metadescription,
                'body_html' => preg_replace( "/\r|\n/", "", ($data->new_description)),
                'handle' => $data->handle
            ),
            'images' => array('metafields' => array("namespace"=> "tags",  "key" => "alt", "value" => "basket of kittens", "value_type" => "string"))
        );
        $product = $shopify('PUT', '/admin/products/'. $data->id_post .'.json', $args);


        // creation d'une redirection (si url a changé)
        if ( isset($data->handle) && $data->handle != '' && isset($data->current_handle) && $data->current_handle != $data->handle){
            // handles différents: ajour d'une redirection
            $argsRedirect = array('redirect' => array('path' => '/products/'. $data->current_handle, 'target' => '/products/'. $data->handle));
            $redirection = $shopify('POST', '/admin/redirects.json', $argsRedirect);
        }
    }

}