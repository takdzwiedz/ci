<?php


namespace MyProject\MyNamespace\Data\Sources;

use MyProject\MyNamespace\Data\Source;
use MyProject\MyNamespace\Helper\Curl;

class SourceTwo extends Source
{

    public function __construct()
    {
        $url = "https://pogoda.interia.pl/prognoza-dlugoterminowa-warszawa,cId,36917";

        $data = new Curl($url);

        $result = $data->result;

        try {
            if ($result) {
                $string = 'weather-currently-temp-strict">';

                if (strpos($result, $string)) {
                    $length = strlen($string);
                    $start = strpos($result, $string) + $length;
                    $temperature = substr($result, $start, 2);
                    $temperature = preg_replace("/[^0-9]/", '', $temperature);
                    $this->setTemperature($temperature);
                }

                // trzeba przeszukać pod kątem przeszukani pierwszych 4 znaków (ciśnienie) następujące po pierwszym wystąpieniu znaku zamknięcia tagu ">" po weather-currently-details-value z uwagi na to, że czasem jest rising, czasem steady w zależności od zmiany ciśnienia.

                // szukam miejsca od którego należy rozpocząć przeszukiwanie.
                $stringPressure = 'Ciśnienie';
                $stringPressureLength = strlen($string);
                //Znajdź położenie słowa Ciśnienie w kodzie;
                $stringPressurePosition = strpos($result, $stringPressure);

                // Ogranicz string do wycinka $stringPressurePosition +1000 znaków;
                $stringWithPressureValue = substr($result, $stringPressurePosition + $stringPressureLength, 1000);

                //Znajdź pierwsze wystąpienie ">". Po nim jest wartość ciśnienia.
                $stringMark = ">";
                $stringMarkLength = 1;
                //Znajdź położenie znacznika">" w wycinku stringa z kodem;
                $stringMarkPosition = strpos($stringWithPressureValue, $stringMark) + $stringMarkLength;

                $pressure = substr($stringWithPressureValue, $stringMarkPosition, 4);
                $pressure = preg_replace("/[^0-9]/", '', $pressure);

                if (strpos($result, $stringPressure)) {
                    $this->setPressure($pressure);
                }

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