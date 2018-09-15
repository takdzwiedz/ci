<?php


namespace MyProject\MyNamespace\Data;

use MyProject\MyNamespace\Helper\Curl;

class SourceTwo extends Source
{
    public $array;

    public function __construct()
    {
        $url = "https://pogoda.interia.pl/prognoza-dlugoterminowa-warszawa,cId,36917";

        $data = new Curl($url);

        $result = $data->result;

        $string = 'weather-currently-temp-strict">';

        if (strpos($result,strpos($result,$string)))
        {
            $length = strlen($string);
            $start = strpos($result,$string) + $length;
            $this->setTemperature(substr($result, $start, 2));
        }

        echo $this->getTemperature();
        die("You are the best around!");

        $this->setArray(array(
            $url => array(
                $this->getTemperature(),
                $this->getPressure()
            )
        ));
    }

    public function getArray()
    {
        return $this->array;
    }

    public function setArray($array)
    {
        $this->array = $array;
    }
}