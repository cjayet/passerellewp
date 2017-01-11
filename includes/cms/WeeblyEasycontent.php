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

    /**
     * WeeblyEasycontent constructor.
     * @param string $siteId
     */
    public function __construct($siteId=''){
        $this->message = '';
        $this->response = array();

        $this->loadAppData();
        if ($siteId!= '')         $this->loadShopConnection($siteId);
    }

    /**
     * load app settings
     */
    public function loadAppData(){
        $db = new EasycontentDB();
        $this->appSettings = $db->getOneRow('SELECT * FROM weebly_appsettings WHERE id="1"');
    }

    /**
     * load client settings
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

        try {
            $this->response['products'] = $this->weebly->get($endpoint);
        }
        catch (Exception $e){
            $this->message = 'Error get products: '. $e->getMessage();
        }

    }

    /**
     * get product detail
     * @param $data
     */
    public function getProduct($data){
        // get detail product
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/products/'. $data->id_product;

        try {
            $this->response['product'] = $this->weebly->get($endpoint);
        }
        catch (Exception $e){
            $this->message = 'Error get product: '. $e->getMessage();
        }
    }

    /**
     * Update existing product
     * @param $data
     */
    public function setProduct($data){
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

        try {
            $this->response['product_images'] = $this->weebly->get($endpoint);
        }
        catch (Exception $e){
            $this->message = 'Error get products: '. $e->getMessage();
        }
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

    /**
     * @param $data
     */
    public function addProductImageFromUrl($data){

        $parameters = array('img_url' => $data->url);
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/products/'. $data->id_post .'/images';

        try {
            $this->response['product_image'] = $this->weebly->post($endpoint, $parameters);
            $this->message = 'Image added';
        }
        catch (Exception $e){
            $this->message = 'Error adding image: '. $e->getMessage();
        }
    }

    /**
     * Add a new product in weebly
     * Acceptable fields: (site_id, name, short_description, skus, options, images)
     * @param $data
     */
    public function addProduct($data){

        // required params
        $parameters = array(
            'name' => $data->name,
            'skus' => array(array(
                'price' => $data->price,
                'product_type' => $data->type
            )),
            'short_description' => $data->description,
            //'images' => array(array('url' => 'http://www.azlegal.com/wp-content/uploads/sites/22/2014/09/corporate_law.jpg'))
        );

        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/products';
        try {
            $resUpload = $this->weebly->post($endpoint, $parameters);

            if ( isset($resUpload->error)) {
                $this->message = 'Error adding product : code '. $resUpload->error->code . ' : ' . $resUpload->error->message;
            }
            else {
                // ok
                $this->message = 'product added';
                $this->response['product'] = $resUpload;
            }
        }
        catch (Exception $e){
            $this->message = 'Error adding product: '. $e->getMessage();
        }
    }

    /**
     * Get all categories
     */
    public function getCategories(){
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/categories';

        try {
            $categories = $this->weebly->get($endpoint);
            $tabCategories = array();
            if (is_array($categories) && count($categories)>0){
                foreach ($categories as $categorie){
                    array_push($tabCategories, array(
                        'id' => $categorie->category_id,
                        'name' => $categorie->name
                    ));
                }
            }

            $this->response['categories'] = $tabCategories;
        }
        catch (Exception $e){
            $this->message = 'Error loading categories: '. $e->getMessage();
        }
    }

    /**
     * Add a new category
     * @param $data
     */
    public function addCategory($data){

        $parameters = array(
            'name' => $data->name,
            'seo_page_title' => $data->meta_title,
            'seo_page_description' => $data->meta_description,
            );

        // set products ?
        if (isset($data->product_id) && count($data->product_id)>0){
            $parameters['product_ids'] = $data->product_id;
        }

        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/categories';
        try {
            $resUpload = $this->weebly->post($endpoint, $parameters);

            if ( isset($resUpload->error)) {
                $this->message = 'Error adding category : code '. $resUpload->error->code . ' : ' . $resUpload->error->message;
            }
            else {
                // ok
                $this->message = 'Category added';
                $this->response['category'] = $resUpload;
            }
        }
        catch (Exception $e){
            $this->message = 'Error adding category: '. $e->getMessage();
        }
    }

    /**
     * Get category details
     */
    public function getCategory($data){
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/categories/'. $data->id_post;

        try {
            $category = $this->weebly->get($endpoint);

            // category image set ?
            if (isset($category->images[0]->url) && $category->images[0]->url != '')    $category_image_url = $category->images[0]->url;
            else                                                                        $category_image_url = '';

            $tabCategory = array(
                'id' => $category->category_id,
                'name' => $category->name,
                'url' => $category->url,
                'image_url' => $category_image_url,
                'seo_title' => $category->seo_page_title,
                'seo_description' => $category->seo_page_description,
                'product_ids' => $category->product_ids
            );
            $this->response['category'] = $tabCategory;
        }
        catch (Exception $e){
            $this->message = 'Error loading categories: '. $e->getMessage();
        }
    }

    /**
     * @param $data
     */
    public function setCategory($data){
        if ($data->action == 'set_category_metatitle'){
            $key = 'seo_page_title';
            $value = 'meta_title';

            if (!isset($data->$value))      $data->$value = '';
        }
        elseif ($data->action == 'set_category_metadescription'){
            $key = 'seo_page_description';
            $value = 'meta_description';
        }
        elseif ($data->action == 'set_category_name'){
            $key = 'name';
            $value = 'new_name';
        }
        elseif ($data->action == 'set_category_products'){
            $key = 'product_ids';
            $value = 'product_id';

            if (!isset($data->$value))      $data->$value = array();
        }
        else {
            $key = '';
        }

        if ($key != ''){

            $parameters = array($key => $data->$value);
            $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/categories/'. $data->id_post;
            try {
                $this->response['category'] = $this->weebly->patch($endpoint, $parameters);
                $this->message = 'Category updated';
            }
            catch (Exception $e){
                $this->message = 'Error patch category: '. $e->getMessage();
            }
        }
        else {
            $this->message = 'Error no action defined';
        }
    }

    /**
     * @param $data
     */
    public function setCategoryImageFromUrl($data){

        $parameters = array(
            'img_url' => trim($data->url)
        );
        $endpoint = '/user/sites/'. $this->userSettings->site_id .'/store/categories/'. $data->id_post .'/images';

        try {
            $resUpload = $this->weebly->post($endpoint, $parameters);
            if ($resUpload->error){
                $this->message = 'Error adding image: code '. $resUpload->error->code . ' : ' . $resUpload->error->message;
            }
            else {
                $this->response['category_image'] = $resUpload;
                $this->message = 'Image added';
            }

        }
        catch (Exception $e){
            $this->message = 'Error adding category image: '. $e->getMessage();
        }
    }

}