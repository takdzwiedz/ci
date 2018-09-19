<?php

namespace MyProject\MyNamespace\Weather;

/*
 * Ta klasa ma wg. treści zadania:
 * - pobierać aktualną pogodę (temperatura w stopniach Celsjusza i ciśnienie (jak jest dostępne) dla Poland Warsaw
 * - Klasa powinna wew. pobrać informacje z 3+ różnych API (zakładam ze to osobne klasy)
 * - Uśrednić wynik
 * - Klasa powinna umożliwić w łatwy i szybki sposób dodanie dodatkowych nowych API do sprawdzania pogody,
 * - idealnie aby wystarczyło zarejestrować nowe API oraz zaimplementować jakiś interfejs. Dzięki temu w przyszłości jak już będziemy mieli 20 różnych API to temperatura będzie bardzo wiarygodna
 * - Obsługa błędów na wypadek problemów z danym API
 * - pobierać dane
 */


class WarsawWeather extends Weather
{

    const PREFIX = "MyProject\MyNamespace\Data\Sources\\";

    public function __construct()
    {
        $data = [];

        foreach (new \DirectoryIterator('src/Data/Sources') as $class)
        {
            if($class->isDot()) continue;
            $class = basename($class, '.php');
            $className = self::PREFIX.$class;
            $obj = new $className;
            $result = get_object_vars($obj);
            array_push($data, $result["array"]);
        }
        $this->setData($data);
        $this->averageValue("temperature");
        $this->averageValue("pressure");
        $this->showAverageData();
    }

    public function averageValue($val)
    {
        $data = $this->getData();

        $summaryValue = 0;
        $i = 0;

        foreach ($data as $key => $value)
        {
            $singleValue = $value[$val];

            if($singleValue)
            {
                $summaryValue += $singleValue;

                $i++;
            }
        }

        $averageValue = round($summaryValue/$i, 2);

        ($val == "temperature") ? $this->setAverageTemperature($averageValue) : $this->setAveragePressure($averageValue);
    }
}
