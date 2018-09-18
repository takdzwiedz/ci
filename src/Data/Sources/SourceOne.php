<?php

namespace MyProject\MyNamespace\Data\Sources;

/*
 * Ta klasa jest przykładową klasą poboru danych z serwisu (API)
 * Ta klasa ma zwracać tablicę z array ( nazwa serwisu = > array ( temperatura, ciśnienie))
 * Ta klasa powinna mieć wyniesiony mechanizm curla na zewnątrz i tylko obrabiać dane właściwe dla danego serwisu.
 * Ta klasa może rozszerzać klasę abstrakcyjną Source.php
 * Ta klasa musi mieć zabezpieczenie na same liczby
 */

use MyProject\MyNamespace\Data\Source;
use MyProject\MyNamespace\Helper\Curl;

class SourceOne extends Source
{

    public function __construct()
    {
        $url = "http://data.twojapogoda.pl/forecasts/city/default/2333";
        $data = new Curl($url);
        $result = $data->result;

        try {
            if ($result) {
                $result = json_decode($result, true);

                $temperature = $result["forecasts"]["default"][0]["temp"];
                $temperature = preg_replace("/[^0-9]/", '', $temperature);

                $this->setTemperature($temperature);

                $pressure = $result["forecasts"]["default"][0]["pressmsl"];
                $pressure = preg_replace("/[^0-9]/", '', $pressure);

                $this->setPressure($pressure);

                $this->setArray(array(
                    $url => array(
                        $this->getTemperature(),
                        $this->getPressure()
                    )
                ));

            } else {
                throw new \Exception('No data from ' . $url);
            }
        } catch (\Exception $ex) {
            echo 'Error: ' . $ex->getMessage();
        }
    }

}
