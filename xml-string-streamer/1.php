<?php

require_once '../vendor/autoload.php';

$options = array(
    "captureDepth" => 2,
    "uniqueNode" => "artNr"
);

// Convenience method for creating a file streamer with the default parser
// $streamer = Prewk\XmlStringStreamer::createStringWalkerParser("test_configurator.xml", $options);
$streamer = Prewk\XmlStringStreamer::createStringWalkerParser("test_productindex.xml", $options);
// $streamer = Prewk\XmlStringStreamer::createStringWalkerParser("gigantic.xml", $options);
echo '<pre>';
// print_r($streamer);
while ($node = $streamer->getNode()) {
    // $node will be a string like this: "<customer><firstName>Jane</firstName><lastName>Doe</lastName></customer>"
    $simpleXmlNode = simplexml_load_string($node);
    // var_dump($simpleXmlNode);
    // echo (string)$simpleXmlNode->firstName . '<br>';
    echo (string)$simpleXmlNode->file->M_Prod_ID . '<br>';
}
echo '</pre>';