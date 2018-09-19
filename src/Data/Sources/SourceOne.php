<?php

namespace MyProject\MyNamespace\Data\Sources;

use MyProject\MyNamespace\Data\DataLoaderInterface;
use MyProject\MyNamespace\Data\DataRetrieverInterface;
use MyProject\MyNamespace\Data\SourceAbstract;
use MyProject\MyNamespace\Helper\Loader;

final class SourceOne extends SourceAbstract implements DataLoaderInterface, DataRetrieverInterface
{

    private $url = "http://data.twojapogoda.pl/forecasts/city/default/2333";

    use Loader;

    public function __construct()
    {
        $this->dataLoader();
    }

    public function dataRetriever()
    {
        $result = $this->getData();
        $result = json_decode(strip_tags($result), true);

        $temperature = $result["forecasts"]["default"][0]["temp"];
        $temperature = preg_replace("/[^0-9]/", '', $temperature);
        $this->setTemperature($temperature);

        $pressure = $result["forecasts"]["default"][0]["pressmsl"];
        $pressure = preg_replace("/[^0-9]/", '', $pressure);
        $this->setPressure($pressure);

        try
        {
            if ($this->getTemperature() && $this->getPressure())
            {
                $this->setArray( $this->getUrl(), $this->getTemperature(), $this->getPressure());
            }
            else
                {
                throw new \Exception("Empty values in $this->url");
                }
        }
        catch (\Exception $ex)
        {
            echo 'Error: ' . $ex->getMessage();
        }

    }

}
