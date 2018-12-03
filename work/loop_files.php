<?php

/**
 * Started with using SimpleXMLElement
 * todo:
 * 1. huge file handling, 
 * 2. DRY, 
 * 3. error preventing and handlig, 
 * 4. reusable solution
 */

$xml = file_get_contents('test_productindex.xml');

$simple_xml = new SimpleXMLElement($xml);

$basePath = '/ICECAT-interface/files.index/file';

$file_index = $simple_xml->xpath('/ICECAT-interface/files.index/file');

echo '<pre>';

// echo '<h1>' . count($file_index) . '</h1>';
// var_dump($file_index->children());

foreach ($file_index as $key => $value) {
    $arr[$key] = $value->attributes();
    // Check if a node has attributes
    if ($value->attributes()) {
        // echo 'File #' . ($key + 1) . ' has attributes<br>';
    }
    // Check if a node has children
    // foreach ($value->children() as $k => $v) {
    //     $arr[$key][$k] = $v;
    // }
}
// print_r($arr);

echo json_encode($arr);

echo '</pre>';