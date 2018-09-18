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
/* Standard nazewniczy: https://symfony.com/doc/current/contributing/code/standards.html lub w skrócie: https://stackoverflow.com/questions/44042304/naming-php-files
 * Ta klasa ma odpalać (__construct) uruchamianie klas dostarczających informację o pogodzie i ciśnieniu atmosferycznym
 * Ta klasa ma mieć tablice która zbiera dane ze wszystkich klas
 * Ta klasa ma dopisywać do tablicy informacje o zebrane z każdej klasy
 * Ta klasa ma przeszukiwać wszystkie (na początek) 3 klasy foreachem
 * Ta klasa ma wyliczać średnią temperaturę i ciśnienie w oparciu o dane z tablicy i zwracać je w returnie w tablicy
 */



class WarsawWeather extends Weather
{
    function __construct()
    {
        $data = [];

        foreach (new \DirectoryIterator('src/Data/Sources') as $class)
        {
            if($class->isDot()) continue;
            $class = basename($class, '.php');
            $className = "MyProject\MyNamespace\Data\Sources\\$class";
            $obj = new $className;
            $result = get_object_vars($obj);
            array_push($data, $result["array"]);

        }
        $this->setData($data);
        $this->averagePressure();
        $this->averageTemperature();
        $this->showAverageData();
    }

    public function averageTemperature()
    {
        $data = $this->getData();
        $i = 0;
        $summaryTemperature = 0;

        foreach ($data as $key => $value)
        {
            foreach ($value as $key2=>$value2)
            {
                $temperature = $value2[0];

                if($temperature)
                {
                    $summaryTemperature += $temperature;
                    $i++;
                }
            }
        }
        $this->setAverageTemperature(round($summaryTemperature/$i, 2));
    }

    public function averagePressure()
    {
        $data = $this->getData();
        $i = 0;
        $summaryPressure = 0;

        foreach ($data as $key => $value)
        {
            foreach ($value as $key2=>$value2)
            {
                $pressure = $value2[1];

                if($pressure)
                {
                    $summaryPressure += $pressure;
                    $i++;
                }
            }
        }
        $this->setAveragePressure(round($summaryPressure/$i, 2));
    }
}
