<?php

/**
 * Created by PhpStorm.
 * User: clement
 * Date: 07/11/2016
 * Time: 17:30
 */
class XMLRPClientWordPress
{
    var $XMLRPCURL = "";
    var $UserName  = "";
    var $PassWord = "";

    // Constructor
    public function __construct($xmlrpcurl, $username, $password)
    {
        $this->XMLRPCURL = $xmlrpcurl;
        $this->UserName  = $username;
        $this->PassWord = $password;
    }


    function send_request($requestname, $params)
    {
        $request = xmlrpc_encode_request($requestname, $params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_URL, $this->XMLRPCURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        $results = curl_exec($ch);
        curl_close($ch);
        return $results;
    }

    function sayHello()
    {
        $params = array();
        return $this->send_request('demo.sayHello',$params);
    }

    function getPages()
    {
        $params = array();
        return $this->send_request('wp.getPages',$params);
    }
}