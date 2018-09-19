<?php


namespace MyProject\MyNamespace\Weather;


abstract class Weather
{
    private $data;

    private $averageTemperature;

    private $averagePressure;

    const TITLE = "Weather in Warsaw";

    const SHOW_TEMPERATURE = "Temperature: ";

    const SHOW_PRESSURE ="Pressure: ";

    abstract function averageValue($val);

    public function showData()
    {
        echo "<pre>";
        print_r($this->getData());
    }

    public function showAverageData()
    {
        echo self::TITLE . "<br><br>";
        echo self::SHOW_TEMPERATURE . $this->getAverageTemperature() . "<br>";
        echo self::SHOW_PRESSURE . $this->getAveragePressure() . "<br>";
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
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getAverageTemperature()
    {
        return $this->averageTemperature;
    }

    /**
     * @param mixed $averageTemperature
     */
    public function setAverageTemperature($averageTemperature)
    {
        $this->averageTemperature = $averageTemperature;
    }

    /**
     * @return mixed
     */
    public function getAveragePressure()
    {
        return $this->averagePressure;
    }

    /**
     * @param mixed $averagePressure
     */
    public function setAveragePressure($averagePressure)
    {
        $this->averagePressure = $averagePressure;
    }
}