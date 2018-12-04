<?php

$url = 'feed_big.xml';
$url = 'test_productindex.xml';
// $url = 'test.xml';

if (empty($url)) {
    die("Please specify xml file to parse.\n");
}

$xml = new XMLReader();
$xml->open($url);

echo '<pre>';

$node_name = 'file';

while ($xml->read() && $xml->name != $node_name) {
}
// var_dump($xml->name);

$output_values = ['Product_ID', 'Catid', 'Model_Name', 'path', 'HighPic'];
$i = 0;
while ($xml->name == $node_name) {
    $element = new SimpleXMLElement($xml->readOuterXML());

    if ($i == 10) break;

    $files[] = [
        $output_values[0] => strval($element->attributes()->{$output_values[0]}),
        $output_values[1] => strval($element->attributes()->{$output_values[1]}),
        $output_values[2] => strval($element->attributes()->{$output_values[2]}),
        $output_values[3] => strval($element->attributes()->{$output_values[3]}),
        $output_values[4] => strval($element->attributes()->{$output_values[4]}),
        // 'Country Markets' => $element->Country_Markets,
        // 'EAN UPCS' => $element->EAN_UPCS,
        // 'M Prod ID' => $element->M_Prod_ID->__toString(),
    ];

    $xml->next($node_name);
    unset($element);
    $i++;
}
// echo "<h1>$i</h1>";
// echo json_encode($files);
print_r($files);

echo '</print>';

$xml->close();