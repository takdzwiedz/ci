<?php

namespace MyProject\MyNamespace\Data;

/*
 * Ta klasa jest przykładową klasą poboru danych z serwisu (API)
 * Ta klasa ma zwracać tablicę z array ( nazwa serwisu = > arrray ( teperatura, ciśnienie))
 * Ta klasa powinna mieć wyniesiony mecchanizm curla na zwenatrz i tylko obrabiać dane włąściwe dla danego serwisu.
 * Ta klasa może rozszerzać klasę abstrakcyjną Source.php
 *
 */

use MyProject\MyNamespace\Helper\Curl;

class SourceOne extends Source
{

    public $array;

    public function __construct()
    {
        $url = "http://data.twojapogoda.pl/forecasts/city/default/2333";
        $data = new Curl($url);
        $result = $data->result;
        $result = json_decode($result, true);
        $this->setTemperature($result["forecasts"]["default"][0]["temp"]);
        $this->setPressure($result["forecasts"]["default"][0]["pressmsl"]);

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
