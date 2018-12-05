<?php

require 'ReadXMLFile.php';

// Let me walk you through the code? - ok

/**
 * Test with test_productindex.xml
 */
$test = new ReadXMLFile(
    'test_productindex.xml',
    [
        'Product_ID', 'Catid', 'Model_Name', 'path', 'HighPic',
    ],
    [
        'Country_Markets', 'EAN_UPCS'
    ],
    'file',
    'csvsdfsdf'
);

/**
 * Test with test.xml
 */
$test = new ReadXMLFile(
    'test.xml',
    [
        'id', 'in_stock', 'is_for_sale', 'lang', 'stock_quantity',
    ],
    [
        'brand', 'cat'
    ],
    'prod',
    'JSONsdgsdg'
);

/**
 * Test with test.xml
 * todo: problem with the same nodes names
 */
// $test = new ReadXMLFile(
//     'test_configurator.xml',
//     [
//         'basketId', 'itemType', 'updateState'
//     ],
//     [
//         'manufacturer', 'series', 'artNr', 'description'
//     ],
//     'bskArticle',
//     'JSON'
// );



echo '<pre>';
echo $test->printResult();
echo '</pre>';