<?php
$string = <<<XML
<a>
 <b>
  <c>text</c>
  <c>stuff</c>
 </b>
 <d>
  <c>code</c>
 </d>
</a>
XML;

$xml = new SimpleXMLElement($string);
// echo '<pre>';
// var_dump($xml);
// echo '</pre><br>';

/* Search for <a><b><c> */
$result = $xml->xpath('/a/b/c');

foreach ($result as $key => $value) {
    // echo $key . '---' . $value . '<br>';
}

echo '<pre>';
var_dump(each($result));
echo '</pre><br>';

while (list(, $node) = each($result)) {
    // echo '/a/b/c: ', $node, "<br>";
}

/* Relative paths also work... */
$result = $xml->xpath('b/c');

while (list(, $node) = each($result)) {
    // echo 'b/c: ', $node, "<br>";
}
?>