<?php

require_once '../vendor/autoload.php';

use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Stream;
use Prewk\XmlStringStreamer\Parser;

$options = array(
    "captureDepth" => 3,
);

// Prepare our stream to be read with a 1kb buffer
$stream = new Stream\File("gigantic.xml", 1024);
$stream = new Stream\File("test_configurator.xml", 1024);

// Construct the default parser (StringWalker)
$parser = new Parser\StringWalker($options);

// Create the streamer
$streamer = new XmlStringStreamer($parser, $stream);

// Iterate through the `<customer>` nodes
while ($node = $streamer->getNode()) {
    // $node will be a string like this: "<customer><firstName>Jane</firstName><lastName>Doe</lastName></customer>"
    $simpleXmlNode = simplexml_load_string($node);
    echo '<pre>';
    var_dump($simpleXmlNode);
    // echo (string)$simpleXmlNode->firstName;
    // echo $simpleXmlNode->bskArticle->manufacturer->name;
    echo '</pre>';
}