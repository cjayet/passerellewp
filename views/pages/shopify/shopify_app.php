<?php

use sandeepshetty\shopify_api;

// database connect
$db = new EasycontentDB();

// get settings
$app_settings = $db->getOneRow("SELECT * FROM tbl_appsettings WHERE id = 1");

if (!empty($_GET['shop']))
{
    $shop = $_GET['shop'];

    // get store in database (if exists)
    $sqlGetStore = "SELECT * FROM tbl_usersettings WHERE store_name = '$shop'";
    $select_store = $db->getOneRow($sqlGetStore); //check if the store exists

    if  (!empty($_GET['code'])) {

        // APP INSTALLATION PART 2
        // Step 3: Capture Access Code
        $code = $_GET['code'];
        $hmac = $_GET['hmac'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['state'];
        $shared_secret = $app_settings->shared_secret;

        // vérification du hmac
        foreach($_GET as $param => $value) {
            if ($param != 'signature' && $param != 'hmac')                 $params[$param] = "{$param}={$value}";
        }
        asort($params);
        $params = implode('&', $params);
        $calculatedHmac = hash_hmac('sha256', $params, $shared_secret);

        // security check : https://help.shopify.com/api/guides/authentication/oauth#verification
        if ($_SESSION['shopify_install_nonce'] == $nonce && $hmac == $calculatedHmac){

            // VALIDATED
            // Step 4: Exchange Access Code for the Shop Token
            $access_token = shopify_api\oauth_access_token(
                $_GET['shop'], $app_settings->api_key, $app_settings->shared_secret, $_GET['code']
            );

            //save the shop details to the database
            if ($select_store->id) {

                // udpdate key
                $sqlClient = 'UPDATE tbl_usersettings
                                SET access_token = "'. $access_token .'"
                                WHERE id="'. $select_store->id .'"';

            }
            else {
                // create client
                $sqlClient = 'INSERT INTO tbl_usersettings (access_token, store_name)
                              VALUES ("'. $access_token .'", "'. $shop .'")';
            }

            $db->executeSql($sqlClient);

        } else {
            // NOT VALIDATED - Someone is being shady!
            echo $_SESSION['shopify_install_nonce'] .' ' . $nonce .' AND '. $hmac == $calculatedHmac ."<br />";
            die('This request is NOT from Shopify!');
        }

        // installation ok : go to app lists
        header('Location: https://'. $shop .'/admin/apps');
    }
    else {

        /// APP INSTALLATION PART 1
        if (!empty($_GET['shop'])) { //check if the shop name is passed in the URL

            if ($select_store->id){
                // shop already registered
                OptimizmeUtils::LoadPage('shopify/welcome');
            }

            // Step 2: Installation Approval
            //convert the permissions to an array
            $permissions = json_decode($app_settings->permissions, true);

            //get the permission url
            $permission_url = shopify_api\permission_url(
                $_GET['shop'], $app_settings->api_key, $permissions
            );

            // generate nonce for security
            $nonce = OptimizmeUtils::generateNonce();
            $_SESSION['shopify_install_nonce'] = $nonce;

            $permission_url .= '&redirect_uri=' . urlencode($app_settings->redirect_url) . "&scope=" . $app_settings->permissions."&state=".$nonce;

            header('Location: ' . $permission_url); //redirect to the permission url

        }
    }

}
