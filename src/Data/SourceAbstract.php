<?php


namespace MyProject\MyNamespace\Data;


abstract class SourceAbstract implements SourceInterface
{
    private $temperature;

    private $pressure;

    private $url;

    private $data;

    public $array;

    /**
     * @return mixed
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param mixed $temperature
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    /**
     * @return mixed
     */
    public function getPressure()
    {
        return $this->pressure;
    }

    /**
     * @param mixed $pressure
     */
    public function setPressure($pressure)
    {
        $this->pressure = $pressure;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getArray()
    {
        return $this->array;
    }

    public function setArray($url, $temperature, $pressure)
    {
        $this->array = array(
            "source" => $url,
            "temperature" => $temperature,
            "pressure" => $pressure
        );
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    public function exceptionValue($val, $url, $type)
    {
        try
        {
            if(is_numeric($val))
            {
                ($type == "temperature") ? $this->setTemperature($val) : $this->setPressure($val);
            }
            else
            {
                throw new \Exception(ucfirst($type) . " $val in $url is non numeric value");
            }
        }
        catch (\Exception $ex)
        {
            echo 'Error: ' . $ex->getMessage();
        }
    }
}