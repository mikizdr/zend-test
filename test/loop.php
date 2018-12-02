<?php
$xmlDoc = new DOMDocument();
$xmlDoc->load("note.xml");
// $xmlDoc->load("test_productindex.xml");

$x = $xmlDoc->documentElement;
foreach ($x->childNodes as $item) {
    print $item->nodeName . " = " . $item->nodeValue . "<br>";
}
?>