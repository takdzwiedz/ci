<?php

namespace MyProject\MyNamespace\Data;

/*
 * Ta klasa jest przykładową klasą poboru danych z serwisu (API)
 * Ta klasa ma zwracać tablicę z array ( nazwa serwisu = > arrray ( teperatura, ciśnienie))
 * Ta klasa powinna mieć wyniesiony mecchanizm curla na zwenatrz i tylko obrabiać dane włąściwe dla danego serwisu.
 * Ta klasa może rozszerzać klasę abstrakcyjną Source.php
 *
 */

class SourceOne
{



    function __construct($url)
    {
        //  Initiate curl
        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        //https://stackoverflow.com/questions/6041741/fastest-way-to-check-if-a-string-is-json-in-php

        if($result)
        {
            $result = json_decode($result, true);

            $temperature = $result["forecasts"]["default"][0]["temp"];

            $pressure = $result["forecasts"]["default"][0]["pressmsl"];

            $array = array(
                $url => array(
                    $temperature,
                    $pressure
                )
            );
            echo "<pre>";
            print_r($array);

        }
        else
        {
            echo 'Error: ' . curl_error($ch);
        }
    }


}
