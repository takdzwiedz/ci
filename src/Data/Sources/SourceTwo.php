<?php


namespace MyProject\MyNamespace\Data\Sources;

use Couchbase\Exception;
use MyProject\MyNamespace\Data\Source;
use MyProject\MyNamespace\Weather\Loader;

class SourceTwo extends Source
{
    private $url ="https://pogoda.interia.pl/prognoza-dlugoterminowa-warszawa,cId,36917";

    use Loader;

    public function retrieveData()
    {
        $result = $this->getData();
        $string = 'weather-currently-temp-strict">';

        try
        {
            if (strpos($result, $string))
            {
                $length = strlen($string);
                $start = strpos($result, $string) + $length;
                $temperature = substr($result, $start, 2);
                $temperature = preg_replace("/[^0-9]/", '', htmlspecialchars($temperature));
                $temperature = preg_replace("/[^0-9]/", '', htmlspecialchars($temperature));
                try
                {
                    if(is_numeric($temperature))
                    {
                        $this->setPressure($temperature);
                    }
                    else
                        {
                        throw new \Exception("Temperature $temperature in $this->url is non numeric value");
                        }
                }
                catch (\Exception $ex)
                {
                    echo 'Error: ' . $ex->getMessage();
                }
            }
            else
                {
                    throw new Exception("No more chance to find temperature in this way from $this->url");
                }
        }
        catch (Exception $ex)
        {
            echo 'Error: ' . $ex->getMessage();
        }


        // trzeba przeszukać pod kątem przeszukani pierwszych 4 znaków (ciśnienie) następujące po pierwszym wystąpieniu znaku   zamknięcia tagu ">" po weather-currently-details-value z uwagi na to, że czasem jest rising, czasem steady w zależności od zmiany ciśnienia.

        // szukam miejsca od którego należy rozpocząć przeszukiwanie.
        $stringPressure = 'Ciśnienie';

        try
        {
            if (strpos($result, $stringPressure))
            {
                $stringPressureLength = strlen($string);
                //Znajdź pierwsze położenie słowa "Ciśnienie" w kodzie;
                $stringPressurePosition = strpos($result, $stringPressure);

                // Ogranicz string do wycinka $stringPressurePosition +1000 znaków;
                $stringWithPressureValue = substr($result, $stringPressurePosition + $stringPressureLength, 1000);

                //Znajdź pierwsze wystąpienie ">". Po nim jest wartość ciśnienia.
                $stringMark = ">";
                $stringMarkLength = 1;
                //Znajdź położenie znacznika">" w wycinku stringa z kodem;
                $stringMarkPosition = strpos($stringWithPressureValue, $stringMark) + $stringMarkLength;

                $pressure = substr($stringWithPressureValue, $stringMarkPosition, 4);
                $pressure = preg_replace("/[^0-9]/", '', htmlspecialchars($pressure));

                try
                {
                    if(is_numeric($pressure))
                    {
                        $this->setPressure($pressure);
                    }
                    else
                    {
                        throw new \Exception("Pressure $pressure in $this->url is non numeric value");
                    }
                }
                catch (\Exception $ex)
                {
                    echo 'Error: ' . $ex->getMessage();
                }
            }
            else
            {
                throw new Exception("No more chance to find pressure in this way from $this->url");
            }
        }
        catch (Exception $ex)
        {
            echo 'Error: ' . $ex->getMessage();
        }





        $this->setArray(array(
            $this->getUrl() => array(
                $this->getTemperature(),
                $this->getPressure()
            )
        ));
    }
}