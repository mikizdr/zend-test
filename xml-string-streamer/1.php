<?php

require_once '../vendor/autoload.php';

// Convenience method for creating a file streamer with the default parser
$streamer = Prewk\XmlStringStreamer::createStringWalkerParser("test_configurator.xml");
// $streamer = Prewk\XmlStringStreamer::createStringWalkerParser("gigantic.xml");

while ($node = $streamer->getNode()) {
    // $node will be a string like this: "<customer><firstName>Jane</firstName><lastName>Doe</lastName></customer>"
    $simpleXmlNode = simplexml_load_string($node);
    echo '<pre>';
    var_dump($simpleXmlNode);
    echo '</pre>';
    // echo (string)$simpleXmlNode->firstName . '<br>';
}