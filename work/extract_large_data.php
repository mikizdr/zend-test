<?php

$argv[1] = 'test_productindex.xml';
// $argv[1] = 'test.xml';

if (empty($argv[1])) {
    die("Please specify xml file to parse.\n");
}

$countIx = 0;

$xml = new XMLReader();
$xml->open('compress.zlib://' . $argv[1]);

$xml->setParserProperty(XMLReader::VALIDATE, true);
// var_dump($xml->isValid());

echo '<pre>';
// var_dump($xml);
// echo '</pre>';
// $m = 1;
// while ($xml->read() && $xml->name != 'file.index') {
//     // echo $xml->name . '<br>';
//     $m++;
// }
$xml->read();
var_dump('Line 27:' . $xml->name);

while ($xml->read() && $xml->name != 'file') {;
}

var_dump($xml->name);


while ($xml->name == 'file') {

    $element = new SimpleXMLElement($xml->readOuterXML());

    // $file = array(
    //     'name' => strval($element->attributes()->Prod_ID),
    //     // 'price' => strval($element->price->buynow),
    //     // 'currency' => strval($element->price->attributes()->curr)
    // );

    // print_r($file);
    // print "\n";
    // $countIx++;

    // $xml->next('file');
    // unset($element);

    $ean_upc_value = $simple_xml->xpath('/ICECAT-interface/files.index/file/EAN_UPCS');
    foreach ($ean_upc_value as $key => $value) {
        print_r($value->xpath('//@Value'));
        foreach ($value->children() as $key => $val) {
            // print_r($val->getName());
            // print_r($val['Value']);
            // echo gettype($val);
            // echo ($val['Value'][0]) . '<br>';
        }
        // print_r($value);
        // var_dump(gettype($value));
    }
}

print "Number of items=$countIx\n";
print "memory_get_usage() =" . memory_get_usage() / 1024 . "kb\n";
print "memory_get_usage(true) =" . memory_get_usage(true) / 1024 . "kb\n";
print "memory_get_peak_usage() =" . memory_get_peak_usage() / 1024 . "kb\n";
print "memory_get_peak_usage(true) =" . memory_get_peak_usage(true) / 1024 . "kb\n";

print "custom memory_get_process_usage() =" . memory_get_process_usage() . "kb\n";

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