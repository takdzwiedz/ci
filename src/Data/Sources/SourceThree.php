<?php


namespace MyProject\MyNamespace\Data\Sources;

use MyProject\MyNamespace\Data\DataLoaderInterface;
use MyProject\MyNamespace\Data\DataRetrieverInterface;
use MyProject\MyNamespace\Data\SourceAbstract;
use MyProject\MyNamespace\Helper\Loader;


final class SourceThree extends SourceAbstract implements DataLoaderInterface, DataRetrieverInterface
{
    private $url = "http://pogodynka.pl/polska/16dni/warszawa_warszawa";

    use Loader;

    public function __construct()
    {
        $this->dataLoader();
    }

    public function dataRetriever()
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