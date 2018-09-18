<?php


namespace MyProject\MyNamespace\Data;


abstract class Source
{

    private $temperature;

    private $pressure;

    private $url;

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

    /**
     * @param mixed $array
     */
    public function setArray($array)
    {
        $this->array = $array;
    }

}