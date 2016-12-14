<?php

use sandeepshetty\shopify_api;


$db = new Mysqli("localhost", "root", "", "shopify");

if ($db->connect_errno) {
    die('Connect Error: ' . $db->connect_errno);
}

$select_settings = $db->query("SELECT * FROM tbl_appsettings WHERE id = 1");
$app_settings = $select_settings->fetch_object();


if (!empty($_GET['shop']) && !empty($_GET['code'])) {
    $shop = $_GET['shop']; //shop name

    //get permanent access token
    $access_token = shopify_api\oauth_access_token(
        $_GET['shop'], $app_settings->api_key, $app_settings->shared_secret, $_GET['code']
    );


    //save the shop details to the database
    $db->query("
     INSERT INTO tbl_usersettings 
     SET access_token = '$access_token',
     store_name = '$shop'
 ");

    //save the signature and shop name to the current session
    $_SESSION['shopify_signature'] = $_GET['signature'];
    $_SESSION['shop'] = $shop;

    header('Location: http://localhost/shopify/shopify_app.php/admin.php');
}
else
    {
    if (!empty($_GET['shop'])) { //check if the shop name is passed in the URL
        $shop = $_GET['shop']; //shop-name.myshopify.com

        $select_store = $db->query("SELECT store_name FROM tbl_usersettings WHERE store_name = '$shop'"); //check if the store exists

        if ($select_store->num_rows > 0) {

            if (shopify_api\is_valid_request($_GET, $app_settings->shared_secret)) { //check if its a valid request from Shopify
                $_SESSION['shopify_signature'] = $_GET['signature'];
                $_SESSION['shop'] = $shop;
                header('Location: http://localhost/shopify/admin.php'); //redirect to the admin page
            }

        } else {

            //convert the permissions to an array
            $permissions = json_decode($app_settings->permissions, true);

            //get the permission url
            $permission_url = shopify_api\permission_url(
                $_GET['shop'], $app_settings->api_key, $permissions
            );
            //$redirect_uri = "http://localhost/generate_token.php";

            //$permission_url .= '&redirect_uri=' . $app_settings->redirect_url ."&scope=". $app_settings->permissions ."&redirect_uri=" . urlencode($redirect_uri);
            $permission_url .= '&redirect_uri=' . $app_settings->redirect_url . "&scope=" . $app_settings->permissions;
            //https://optimiz-me-dev.myshopify.com/admin/oauth/authorize?client_id=&redirect_uri=

            header('Location: ' . $permission_url); //redirect to the permission url
        }
    }
}