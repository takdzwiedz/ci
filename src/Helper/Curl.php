<?php


namespace MyProject\MyNamespace\Helper;




class Curl
{
    public function __construct($url)
    {
        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        return $result;

        //https://stackoverflow.com/questions/6041741/fastest-way-to-check-if-a-string-is-json-in-php

    }
}