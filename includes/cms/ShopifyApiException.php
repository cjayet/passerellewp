<?php
/**
 *  Workaround for Class "ApiException" not defined in sandeepshetty\shopify_api\client.php
 */

namespace sandeepshetty\shopify_api;

class ApiException extends Exception {

    public function __construct($array){
        throw new \Exception('Error ApiException with Shopify');
    }
}