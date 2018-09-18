<?php


namespace MyProject\MyNamespace\Data\Sources;

use MyProject\MyNamespace\Data\Source;
use MyProject\MyNamespace\Weather\Loader;


class SourceThree extends Source
{
    private $url = "http://pogodynka.pl/polska/16dni/warszawa_warszawa";

    use Loader;

    public function retrieveData()
    {
        $result = $this->getData();

        $string = '°C';
        $temperature = substr($result, strpos($result, $string)-2,2 );
        $temperature = preg_replace("/[^0-9]/", '', $temperature);
        try
        {
            if(is_numeric($temperature))
            {
                $this->setTemperature($temperature);
            }
            else
            {
                throw new \Exception("$temperature in $this->url is non numeric value");
            }
        }
        catch (\Exception $ex)
        {
            echo 'Error: ' . $ex->getMessage();
        }

        $string = " hPa";
        $pressure = substr($result, strpos($result, $string)-4,4);
        $pressure = preg_replace("/[^0-9]/", '', $pressure);

        try
        {
            if(is_numeric($pressure))
            {
                $this->setPressure($pressure);
            }
            else
            {
                throw new \Exception("$pressure in $this->url is non numeric value");
            }
        }
        catch (\Exception $ex)
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