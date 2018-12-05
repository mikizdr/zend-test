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

$file_index = $simple_xml->xpath('/ICECAT-interface');

$basePath = '/ICECAT-interface/files.index/file';

echo '<pre>';

/**
 * Product ID attribut
 */
// $product_id = $simple_xml->xpath('//@Product_ID');
// echo '<h1>Product ID</h1>';
// foreach ($product_id as $key => $value) {
//     if ($value != '') {
//         print 'Product ID: ' . $value . '<br>';
//     }
// }

// /**
//  * CatID attribut
//  */
// $catId = $simple_xml->xpath('//@Catid');
// echo '<h1>CatID</h1>';
// foreach ($catId as $key => $value) {
//     echo $value . '<br>';
// }

// /**
//  * Model name attribute
//  */
// $model_name = $simple_xml->xpath('//@Model_Name');
// echo '<h1>Model Name</h1>';
// foreach ($model_name as $key => $value) {
//     if ($value != '') {
//         print 'Model name: ' . $value . '<br>';
//     }
// }

// /**
//  * Path attribute
//  */
// $path = $simple_xml->xpath('//@path');
// echo '<h1>Path</h1>';
// foreach ($path as $key => $value) {
//     if ($value != '') {
//         print 'Path: ' . $value . '<br>';
//     }
// }

// /**
//  * High pic attribute
//  */
// $high_pics = $simple_xml->xpath('//@HighPic');
// echo '<h1>HighPic</h1>';
// foreach ($high_pics as $key => $value) {
//     if ($value != '') {
//         print 'High pic: ' . $value . '<br>';
//     }
// }

/**
 * Country Markets node
 * In the example, you see 2 foreach loops and they are iterating through node and its children. In this way the result is like this. - you're not using the class you made here? No
 * This is just testing and preparation. - ok
 * go on ;)
 * So, here we have selecting elements by xpath
 */
$country_markets = $simple_xml->xpath($basePath . '/Country_Markets'); // xpath to the element
echo '<h1>Country Markets</h1>';
// var_dump($country_markets);
foreach ($country_markets as $key => $value) {
    // loop through each value
    foreach ($value as $a => $val) {
        // This gives the next output
        $kids[$key][$a][] = strval($val->attributes()); // attributes comes from here <Country_Market Value="PL"/> so for node Country_Market attribute is Value, and we get this: an array with 3 arrays that contain elements...
        // if compare with this
    }
}
print_r($kids);

/**
 * EAN UPCS node
 */
$ean_upcs = $simple_xml->xpath($basePath . '/EAN_UPCS');
// echo '<h1>EAN UPCS</h1>';
foreach ($ean_upcs as $key => $value) {
    foreach ($value->children() as $a => $val) {
        $eans[$key][$a][] = strval($val->attributes());
    }
}
// print_r($eans);

echo '</pre>';