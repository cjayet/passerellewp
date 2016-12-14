<?php
require 'vendor/autoload.php';
use sandeepshetty\shopify_api;

// Set variables for our request
$shop = "optimiz-me-dev.myshopify.com";
$token = "81dbd9fd6d0d2a31f27286724461ef65";
$query = array(
	"Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
);


// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('shopify/head_push'); ?>
            <form>
                <button type="button" data-id="action" id="load_site_options" class="btn btn-primary">Load products</button>
                <div id="easycontent-url" value="" />
            </form>
            <hr /><br />
        </div>
    </div>


    <div class="row" >
        <div class="col-md-12">
            <?php

            $shopify = shopify_api\client(
                //$shop, $shop_data->access_token, $app_settings->api_key, $app_settings->shared_secret
                $shop, '81dbd9fd6d0d2a31f27286724461ef65', '2cba3b567d19031ae9e4900cafed2e96', '824b1bd54e591972deb0ed99ef724327'
            );

            $products = $shopify('GET', '/admin/products.json', array('published_status' => 'published'));

            echo '<h3>'. count($products) . ' produits au total<h3>';
            OptimizmeUtils::nice($products);

            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>
</div>

</body>
</html>