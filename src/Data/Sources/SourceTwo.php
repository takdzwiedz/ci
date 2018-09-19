<?php


namespace MyProject\MyNamespace\Data\Sources;

use Couchbase\Exception;
use MyProject\MyNamespace\Data\Source;
use MyProject\MyNamespace\Weather\Loader;

final class SourceTwo extends Source
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
                $this->exceptionValue($temperature, $this->url, "temperature");
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

        $stringPressure = 'Ciśnienie';

        try
        {
            if (strpos($result, $stringPressure))
            {
                $stringPressureLength = strlen($string);
                $stringPressurePosition = strpos($result, $stringPressure);
                $stringWithPressureValue = substr($result, $stringPressurePosition + $stringPressureLength, 200);
                $stringMark = ">";
                $stringMarkLength = 1;
                $stringMarkPosition = strpos($stringWithPressureValue, $stringMark) + $stringMarkLength;
                $pressure = substr($stringWithPressureValue, $stringMarkPosition, 4);
                $pressure = preg_replace("/[^0-9]/", '', htmlspecialchars($pressure));
                $this->exceptionValue($pressure, $this->url, "pressure");
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

        $this->setArray( $this->getUrl(), $this->getTemperature(), $this->getPressure());
    }
}