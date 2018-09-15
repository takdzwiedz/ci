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

        if (strpos($result,$string))
        {
            $length = strlen($string);
            $start = strpos($result,$string) + $length;
            $this->setTemperature(substr($result, $start, 2));
        }

        // trzeba przeszukać pod kątem przeszukani pierwszych 4 znaków (ćiśnienie) nasepujące po pierwszym wystąpieniu znaku zamknięcia tagu ">" po weather-currently-details-value z uwagi na to, że czasem jest rising, czasem steady w zalżeności od zmiany ciśnienia.
        $string = 'weather-currently-details-value rising">';
        if (strpos($result,$string))
        {
            $length = strlen($string);
            $start2 = strpos($result,$string) + $length;
            $this->setPressure(substr($result, $start2, 4));
        }
//
//        echo $this->getTemperature();
//        echo "<br>";
//        echo $this->getPressure();
//        echo "<br>";
//        die("You are the best around!");

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