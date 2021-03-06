<?php

$argv[1] = 'feed_big.xml';
$argv[1] = 'test_productindex.xml';
// $argv[1] = 'test.xml';

if (empty($argv[1])) {
    die("Please specify xml file to parse.\n");
}

$countIx = 0;

$xml = new XMLReader();
$xml->open('compress.zlib://' . $argv[1]);

echo '<pre>';
// var_dump($xml);
// echo '</pre>';
// $m = 1;
// while ($xml->read() && $xml->name != 'file.index') {
//     // echo $xml->name . '<br>';
//     $m++;
// }

$node_name = 'file';

while ($xml->read() && $xml->name != $node_name) {;
}
// var_dump($xml->name);
while ($xml->name == $node_name) {
    $element = new SimpleXMLElement($xml->readOuterXML());
    // var_dump($element);
    // if (strval($element->attributes()->Catid) == 827) {
    //     continue;
    // }
    $files[] = [
        // 'path' => strval($element->attributes()->path),
        // 'CatID' => strval($element->attributes()->Catid),
        // 'Model Name' => strval($element->attributes()->Model_Name),
        // 'High Picture' => strval($element->attributes()->HighPic),
        // 'Product ID' => strval($element->attributes()->Product_ID),
        // 'Country Markets' => $element->Country_Markets,
        // 'M Prod ID' => $element->M_Prod_ID->__toString(),
        'EAN UPCS' => $element->EAN_UPCS,
    ];

    $countIx++;

    $xml->next($node_name);
    unset($element);
}
// echo json_encode($files);
print_r($files);
// print_r($kids);
print "\n";

/**
 * Memory consumption
 */
// print "Number of items=$countIx\n";
// print "memory_get_usage() =" . memory_get_usage() / 1024 . "kb\n";
// print "memory_get_usage(true) =" . memory_get_usage(true) / 1024 . "kb\n";
// print "memory_get_peak_usage() =" . memory_get_peak_usage() / 1024 . "kb\n";
// print "memory_get_peak_usage(true) =" . memory_get_peak_usage(true) / 1024 . "kb\n";

// print "custom memory_get_process_usage() =" . memory_get_process_usage() . "kb\n";

echo '</print>';

$xml->close();

/**
 * Returns memory usage from /proc<PID>/status in bytes.
 *
 * @return int|bool sum of VmRSS and VmSwap in bytes. On error returns false.
 */
function memory_get_process_usage()
{
    $status = file_get_contents('/proc/' . getmypid() . '/status');

    $matchArr = array();
    preg_match_all('~^(VmRSS|VmSwap):\s*([0-9]+).*$~im', $status, $matchArr);

    if (!isset($matchArr[2][0]) || !isset($matchArr[2][1])) {
        return false;
    }

    return intval($matchArr[2][0]) + intval($matchArr[2][1]);
}