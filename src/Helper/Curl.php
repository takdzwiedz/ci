<?php


namespace MyProject\MyNamespace\Helper;


class Curl
{
    private $url;

    public $result;

    function __construct($url)
    {
        $this->url = $url;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL,$url);

        $result=curl_exec($ch);

        curl_close($ch);

        if($result)
        {
            return $this->setResult($result);
        }
        else
        {
            echo 'Error: ' . curl_error($ch);
        }
    }

    public function setResult($result)
    {
        $this->result = $result;
    }

}