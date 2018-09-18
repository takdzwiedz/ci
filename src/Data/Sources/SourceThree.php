<?php


namespace MyProject\MyNamespace\Data\Sources;

use MyProject\MyNamespace\Data\Source;
use MyProject\MyNamespace\Helper\Curl;


class SourceThree extends Source
{

    public function __construct()
    {
        $url = "http://pogodynka.pl/polska/16dni/warszawa_warszawa";

        $data = new Curl($url);

        $result = $data->result;

        try
        {
            if($result)
            {

                $string = '°C';

                $temperature = substr($result, strpos($result, $string)-2,2 );

                $temperature = preg_replace("/[^0-9]/", '', $temperature);

                $this->setTemperature($temperature);

                $string = " hPa";

                $pressure = substr($result, strpos($result, $string)-4,4);

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
        } catch (\Exception $ex){
            echo 'Error: ' . $ex->getMessage();
        }
    }
}