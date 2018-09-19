<?php


namespace MyProject\MyNamespace\Data;


interface SourceInterface
{
    public function getTemperature();

    public function setTemperature($temperature);

    public function getPressure();

    public function setPressure($pressure);

    public function getUrl();

    public function setUrl($url);

    public function getArray();

    public function setArray($url, $temperature, $pressure);

    public function getData();

    public function setData($data);

    public function exceptionValue($val, $url, $type);
}