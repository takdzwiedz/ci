<?php

include 'Psr4Autoloader.php';

$obj = new \MyProject\MyNamespace\Weather\WarsawWeather();
$obj->showData();