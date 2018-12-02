<?php

$xml = file_get_contents('test_productindex.xml');

$files_index = new SimpleXMLElement($xml);

$path = $files_index->xpath('//@path');

echo '<pre>';
foreach ($path as $key => $value) {
    echo $value . '<br>';
}
// echo $path[0];
// var_dump($files_index);
echo '</pre>';