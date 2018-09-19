<?php


namespace MyProject\MyNamespace\Data\Sources;

use MyProject\MyNamespace\Data\Source;
use MyProject\MyNamespace\Weather\Loader;


final class SourceThree extends Source
{
    private $url = "http://pogodynka.pl/polska/16dni/warszawa_warszawa";

    use Loader;

    public function retrieveData()
    {
        $result = $this->getData();

        $string = '°C';
        $temperature = substr($result, strpos($result, $string)-2,2 );
        $temperature = preg_replace("/[^0-9]/", '', $temperature);
        $this->exceptionValue($temperature, $this->url, "temperature");

        $string = " hPa";
        $pressure = substr($result, strpos($result, $string)-4,4);
        $pressure = preg_replace("/[^0-9]/", '', $pressure);
        $this->exceptionValue($pressure, $this->url, "pressure");

        $this->setArray( $this->getUrl(), $this->getTemperature(), $this->getPressure());
    }
}