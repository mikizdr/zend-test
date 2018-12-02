<?php

require 'XmlToJson.php';

$url = 'test_configurator.xml';
// $url = 'test_productindex.xml';
print XmlToJson::Parse($url);