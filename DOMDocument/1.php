<?php
$xmlDoc = new DOMDocument();
$xmlDoc->load("test_productindex.xml");
// $xmlDoc->load("note.xml");

print $xmlDoc->saveXML();
?>