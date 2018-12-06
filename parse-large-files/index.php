<?php

require 'ReadXMLFile.php';

/**
 * Test with test_productindex.xml
 */
$test1 = new ReadXMLFile(
    'test_productindex.xml',
    [
        'Product_ID', 'Catid', 'Model_Name', 'path', 'HighPic',  // selected attributes for output
    ],
    [
        'Country_Markets', 'EAN_UPCS'                        // selected nodes for output
    ],
    'file',                                                  // main node name
    'JSON',                                                   // output format
    true,                                                    // Read from attribute values of nodes 'Country_Markets', 'EAN_UPCS'
    'Product_ID',                                            // the name of attribute by which the data will be filtered out
    // 'Catid',
    [44673],                                                 // filter by this value for Product_ID
    // [587, 827],                                           // filter by this value for Catid
    false                                                    // if true the data will be filtered out by previous values
);

/**
 * Test with test_configurator.xml
 * todo: problem with the same nodes names. It should be resolved in custom script.
 */
$test2 = new ReadXMLFile(
    'test_configurator.xml',
    [
        'basketId', 'itemType', 'updateState' // attributes
    ],
    [
        'manufacturer', 'series', 'artNr', 'description', 'features' // nodes
        // 'description' // nodes
        // 'features' // nodes
    ],
    'bskArticle',
    'csv' // Output format (JSON, csv, ...). Default is JSON.
);



echo '<pre>';
echo $test1->printResult();
echo '</pre>';