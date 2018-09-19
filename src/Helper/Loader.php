<?php


namespace MyProject\MyNamespace\Helper;


trait Loader
{
    public function dataLoader()
    {
        $this->setUrl($this->url);
        $data = new Curl($this->url);
        $result = $data->result;

        try
        {
            if ($result)
            {
                $this->setData($result);
                $this->dataRetriever();
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