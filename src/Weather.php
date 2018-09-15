<?php

namespace MyProject\MyNamespace;

/*
 * Ta klasa ma wg. treści zadania:
 * - pobierać aktualną pogodę (temperatura w stopniach Celsjusza i ciśnienie (jak jest dostępne) dla Poland Warsaw
 * - Klasa powinna wew. pobrać informacje z 3+ różnych API (zakladam ze to osobne klasy)
 * - Uśrednić wynik
 * - Klasa powinna umożliwić w łatwy i szybki sposób dodanie dodatkowych nowych API do sprawdzania pogody,
 * - idealnie aby wystarczyło zarejestrować nowe API oraz zaimplementować jakiś interfejs. Dzięki temu w przyszłości jak już będziemy mieli 20 różnych API to temperatura będzie bardzo wiarygodna
 * - Obsługa błędów na wypadek problemów z danym API
 * - pobierać dane
 */
/* Standaard nazewniczy: https://symfony.com/doc/current/contributing/code/standards.html lub w skrócie: https://stackoverflow.com/questions/44042304/naming-php-files
 * Ta klasa ma odpalać (__construct) uruchamianie klas dostarczających inforamcję o pogodzie i ciśnieniniu atmosferycznym
 * Ta klasa ma mieć tablice która zbiera dane ze wszystkich klas
 * Ta klasa ma dopisywać do tablicy inforamcje o zebrane z każdej klasy
 * Ta klasa ma przeszukiwać wszystkie (na początek) 3 klasy foreachem
 * Ta klasa ma wyliczać średnią temperaturę i ciśnienie w oparciu o dane z tablicy i zwracać je w returnie w tablicy
 * Jak wywołać nowe obiekty wszystkich klas w folderze?
 * Jak mam odzyskać tablicę z klasy?
 */


class Weather
{
    function __construct()
    {

        $array = [];

        $answer = new Data\SourceOne();
        $result = get_object_vars($answer);



        array_push($array, $result["array"]);
        echo "<pre>";
        print_r($array[0]);

        $answer2 = new Data\SourceTwo();

    }

    // https://stackoverflow.com/questions/599670/how-to-include-all-php-files-from-a-directory
    // https://stackoverflow.com/questions/21559957/create-instances-of-all-classes-in-a-directory-with-php

}