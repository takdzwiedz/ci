<?php


namespace MyProject\MyNamespace\Data;

use MyProject\MyNamespace\Helper\Curl;

class SourceThree extends Source
{

    public $array;

    public function __construct()
    {
        $url = "http://pogodynka.pl/polska/16dni/warszawa_warszawa";

        $data = new Curl($url);

        $result = $data->result;

        $string = '°C';

        $temperature = substr($result, strpos($result, $string)-2,2 );
        $this->setTemperature($temperature);

//        echo $temperature;

        $string = " hPa";
        $pressure = substr($result, strpos($result, $string)-4,4);
        $this->setPressure($pressure);
//        echo $pressure;
//        echo "<br>";
//        die("OK");



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