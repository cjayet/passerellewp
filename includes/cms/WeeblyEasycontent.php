<?php

/**
 * Created by PhpStorm.
 * User: clement
 * Date: 09/01/2017
 * Time: 13:00
 */
class WeeblyEasycontent
{

    public $appSettings;
    public $userSettings;
    public $weebly;
    public $response;
    public $message;

    public function __construct($siteId=''){
        $this->message = '';
        $this->response = array();
        $this->loadAppData();
        if ($siteId!= '')         $this->loadShopConnection($siteId);
    }

    public function loadAppData(){
        $db = new EasycontentDB();
        $this->appSettings = $db->getOneRow('SELECT * FROM weebly_appsettings WHERE id="1"');
    }

    /**
     * @param $siteId
     */
    public function loadShopConnection($siteId){

        if ($this->getInformationsByShopName($siteId))
        {
            if ($this->userSettings->id != ''){

                // connexion client ok
                $client = new \Weebly\WeeblyClient($this->appSettings->client_id, $this->appSettings->client_secret, $this->userSettings->user_id, $this->userSettings->site_id, $this->userSettings->access_token);
                $this->weebly = $client;
            }

            else {
                // erreur connexion
                echo json_encode( array('result' => 'Erreur', 'message' => 'Erreur de connexion à la boutique : is credentials in database ?'));
                die;
            }
        }

    }


    /**
     * @param $shop
     * @return string
     */
    public function getInformationsByShopName($shop){
        $sql = 'SELECT * FROM weebly_usersettings WHERE site_id="'. $shop .'" LIMIT 1';
        $db = new EasycontentDB();

        try {
            $stmt = $db->dbh->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetchObject();
            $this->userSettings = $row;
            return true;
        }
        catch (Exception $e){
            return false;
        }

    }


    /**
     * get products list
     */
    public function getProducts(){
        // get products list from site
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/products';
        $this->response['products'] = $this->weebly->get($endpoint);
    }


    /**
     * get product detail
     * @param $data
     */
    public function getProduct($data){
        // get detail product
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/products/'. $data->id_product;
        $this->response['product'] = $this->weebly->get($endpoint);
    }

    /**
     * Update existing product
     * @param $data
     */
    public function patchProduct($data){
        $parameters = array(
            'name' => $data->name,
            'short_description' => $data->product_description
        );

        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/products/'. $data->id_post;
        try {
            $this->response['product'] = $this->weebly->patch($endpoint, $parameters);
            $this->message = 'Product updated';
        }
        catch (Exception $e){
            $this->message = 'Error patchProduct: '. $e->getMessage();
        }
    }

    /**
     * Get all image for a given product
     * @param $data
     */
    public function getProductImages($data){
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/products/'. $data->id_product .'/images';
        $this->response['product_images'] = $this->weebly->get($endpoint);
    }


    /**
     * @param $data
     */
    public function deleteProductImage($data){
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/products/'. $data->id_product .'/images/'. $data->id_product_image;

        try {
            $this->response['product_images'] = $this->weebly->delete($endpoint);
            $this->message = 'Image deleted';
        }
        catch (Exception $e){
            $this->message = 'Error deleting image: '. $e->getMessage();
        }
    }


    public function addProductImageFromUrl($data){

        $parameters = array('img_url' => $data->url);
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/products/'. $data->id_product .'/images/'. $data->id_product_image;

        try {
            $this->response['product_image'] = $this->weebly->post($endpoint, $parameters);
            $this->message = 'Image added';
        }
        catch (Exception $e){
            $this->message = 'Error adding image: '. $e->getMessage();
        }
    }

}