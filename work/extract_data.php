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
echo '<h1>Path</h1>';
foreach ($path as $key => $value) {
    if ($value != '') {
        print 'Path: ' . $value . '<br>';
    }
}

$high_pics = $simple_xml->xpath('//@HighPic');
echo '<h1>HighPic</h1>';
foreach ($high_pics as $key => $value) {
    if ($value != '') {
        print 'High pic: ' . $value . '<br>';
    }
}

$model_name = $simple_xml->xpath('//@Model_Name');
echo '<h1>Model Name</h1>';
foreach ($model_name as $key => $value) {
    if ($value != '') {
        print 'Model name: ' . $value . '<br>';
    }
}

$product_id = $simple_xml->xpath('//@Product_ID');
echo '<h1>Product ID</h1>';
foreach ($product_id as $key => $value) {
    if ($value != '') {
        print 'Product ID: ' . $value . '<br>';
    }
}

$basePath = '/ICECAT-interface/files.index/file';


$country_markets = $simple_xml->xpath($basePath . '/Country_Markets');
echo '<h1>Country Markets</h1>';

// for ($i = 0; $i < count($country_markets); $i++) {
foreach ($country_markets as $key => $value) {
    // echo '<h1>' . count($value) . '</h1>';
        // print_r($value);
        // var_dump($value);
    foreach ($value as $a => $val) {
                    // echo '<h1>' . count($val) . '</h1>';
        $kids[$key][$a][] = strval($val->attributes());
                    // var_dump($val);
        // echo $a . '-' . $val->attributes() . '<br>';
                    // echo '<br>+++++++++++++++++++++++++++<br>';
    }
        // print 'Market: ' . $value->children() . '<br>';
        // foreach ($value->children() as $child) {
        //     print $child;
        // }
}
// }
print_r($kids);


/**
 * CatID
 */
$catId = $simple_xml->xpath('//@Catid');
echo '<h1>CatID</h1>';
foreach ($catId as $key => $value) {
    echo $value . '<br>';
}

$ean_upcs = $simple_xml->xpath('/ICECAT-interface/files.index/file/EAN_UPCS');
//file/EAN_UPCS/@Value
echo '<h1>EAN UPCS</h1>';
// echo '<h1>' . count($ean_upcs) . '</h1>';
foreach ($ean_upcs as $key => $value) {
    // print_r($value->xpath('//@Value'));
    // echo '<h1>' . count($value) . '</h1>';
    foreach ($value->children() as $a => $val) {
        // echo '<h1>' . count($val) . '</h1>';
        // print_r($val->getName());
        // print_r($val['Value']);
        // echo gettype($val);
        $eans[$key][$a][] = strval($val->attributes());
        // echo ($val['Value'][0]) . '<br>';
    }
    // print_r($value);
    // var_dump(gettype($value));
}
print_r($eans);

$m_prod_ids = $simple_xml->xpath('/ICECAT-interface/files.index/file/M_Prod_ID');
echo '<h1>M Prod ID</h1>';
echo '<h1>' . var_dump($m_prod_ids) . '</h1>';
foreach ($m_prod_ids as $key => $value) {
    foreach ($value->children() as $a => $val) {
        $eans[$key][$a][] = strval($val->attributes());
    }
}
print_r($eans);
// echo $path[0];
// var_dump($simple_xml);
echo '</pre>';