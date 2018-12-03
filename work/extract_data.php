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

$output = [];

/*
Looking at test_productindex.xml, I want to filter 'file' with an attribute
'Catid' containing '587', and show a report on screen with
- Product_ID,
- Model_Name
- path (link to detail-xml)
- HighPic
- a list of EAN_UPC Values

For example, using the test-file this would produce: # test-file??? new file or...?

Product 30114
-------------
Title (file node attribute: Model_Name):      Lightweight Tripod VCT-R640
Image (file node attribute: HighPic):      http://images.icecat.biz/img/norm/high/30114-Sony.jpg
Detail-XML (file node attribute: path): export/level4/NL/30114.xml
EANs (EAN_UPCS node > EAN_UPC node > Value attribute):
- 4901780776467
- 5053460903188
 */
$Product_id = '';
$Model_Name = '';
$path = '';
$HighPic = '';

$file_index = $simple_xml->xpath('/ICECAT-interface');

echo '<pre>';

/**
 * Playing with root node
 */
// var_dump($file_index);
foreach ($file_index as $key => $value) {
    // print_r($value);
    // echo count($value) . '<br>';
    foreach ($value->children()->attributes() as $a => $b) {
        // foreach ($b as $key => $value) {
        //     echo 
        // }
        // echo $a, '="', $b, "\"\n";
    }
}

$path = $simple_xml->xpath('//@path');
foreach ($path as $key => $value) {
    // print $value . '<br>';
}

$basePath = '/ICECAT-interface/files.index/file';


$country_markets = $simple_xml->xpath($basePath . '/Country_Markets');
echo '<h1>' . count($country_markets) . '</h1>';

for ($i = 0; $i < count($country_markets); $i++) {
    foreach ($country_markets as $key => $value) {
        echo '<h1>' . count($value) . '</h1>';
        // print_r($value);
        // var_dump($value);
        foreach ($value as $a => $val) {
            // echo '<h1>' . count($val) . '</h1>';
            $kids[$i][$a] = $val->attributes();
            // var_dump($val);
            echo $a . '-' . $val->attributes() . '<br>';
            // echo '<br>+++++++++++++++++++++++++++<br>';
        }
        // print 'Market: ' . $value->children() . '<br>';
        // foreach ($value->children() as $child) {
        //     print $child;
        // }
    }
}
// print_r($kids);
$catId = $simple_xml->xpath('//@Catid');
$ean_upc_value = $simple_xml->xpath('/ICECAT-interface/files.index/file/EAN_UPCS');
//file/EAN_UPCS/@Value

// var_dump($ean_upc_value);
foreach ($ean_upc_value as $key => $value) {
    // print_r($value->xpath('//@Value'));
    foreach ($value->children() as $key => $val) {
        // print_r($val->getName());
        // print_r($val['Value']);
        // echo gettype($val);
        // echo ($val['Value'][0]) . '<br>';
    }
    // print_r($value);
    // var_dump(gettype($value));
}
// echo $path[0];
// var_dump($simple_xml);
echo '</pre>';