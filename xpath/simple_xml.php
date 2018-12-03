<?php

$xml = file_get_contents('test_productindex.xml');

$files_index = new SimpleXMLElement($xml);

$path = $files_index->xpath('//@path');
$catId = $files_index->xpath('//@Catid');

echo '<pre>';
foreach ($catId as $key => $value) {
    echo $value . '<br>';
}
// echo $path[0];
// var_dump($files_index);
echo '</pre>';