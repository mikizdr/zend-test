<?php

// Load external XML file
$html = file_get_contents('test_productindex.xml');

// DOM object
$dom = new DOMDocument();

// Disable libxml errors
libxml_use_internal_errors(true);

if (!empty($html)) {

    // Load HTML from a string
    $dom->loadHTML($html);
    // Clears the libxml error buffer
    libxml_clear_errors();
	// Work with xpath
    $dom_xpath = new DOMXPath($dom);

    echo '<pre>';
    // var_dump($dom_xpath);
    echo '</pre>';

    /**
     * JSON response
     */
    // echo "<pre>";
    // print_r(json_encode($items));
    // echo "</pre>";

}