<?php


namespace MyProject\MyNamespace\Weather;

use MyProject\MyNamespace\Helper\Curl;

trait Loader
{
    public function __construct()
    {
        $this->setUrl($this->url);
        $data = new Curl($this->url);
        $result = $data->result;

        try
        {
            if ($result)
            {
                $this->setData($result);
                $this->retrieveData();
            }
            else
            {
                throw new \Exception('No data from ' . $this->url);
            }
        }
        catch (\Exception $ex)
        {
            echo 'Error: ' . $ex->getMessage();
        }
    }
}