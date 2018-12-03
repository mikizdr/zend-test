<?php

// Load external HTML file
$html = file_get_contents('test.html'); 

// DOM object
$dom = new DOMDocument();

// Disable libxml errors
libxml_use_internal_errors(TRUE); 

if (!empty($html)) {

    // Load HTML from a string
    $dom->loadHTML($html);
    // Clears the libxml error buffer
	libxml_clear_errors();
	// Work with xpath
	$dom_xpath = new DOMXPath($dom);

    $item_number       = $dom_xpath->query('//span[starts-with(@class,"value")]');
    $item_description  = $dom_xpath->query('//div[starts-with(@class,"variant-description")]');
    $pq                = $dom_xpath->query('//div[starts-with(@class,"variant-pq")]');
    $product_price     = $dom_xpath->query('//div[starts-with(@class,"product-price")]');
    $available_qty     = $dom_xpath->query('//div[starts-with(@class,"variant-availablequantity")]');

    /**
     * Image paths
     */
    $imageTags = $dom->getElementsByTagName('img');
    foreach ($imageTags as $tag) {
        $imagepaths[] = $tag->getAttribute('src');
    }

    $item_attributes = ['Item Number', 'Item Description', 'PQ', 'Product Price', 'Qty Available', 'Image Source'];

	if ($item_number) {
        for ($i = 0; $i < $item_number->length; $i++) {
            //todo: make unique function
            foreach ($item_number as $key => $row ){
                if ($key - 1 != $i) continue;
                $items[$i]['Item Number'] = trim($row->nodeValue);
            }
            foreach ($item_description as $key => $row) {
                if ($key != $i) continue;
                $items[$i]['Item Description'] = trim($row->nodeValue);
            }
            foreach ($pq as $key => $row) {
                if ($key != $i) continue;
                $items[$i]['PQ'] = trim($row->nodeValue);
            }
            foreach ($product_price as $key => $row) {
                if ($key != $i) continue;
                $items[$i]['Product Price'] = trim($row->nodeValue);
            }
            foreach ($available_qty as $key => $row) {
                if ($key != $i) continue;
                $items[$i]['Qty Available'] = (int) trim($row->nodeValue);
            }
            foreach ($imagepaths as $key => $value) {
                if ($key - 1 != $i) continue;
                $items[$i]['Image Source'] = $value;
            }
        }
    }

    /**
     * JSON response
     */
    // echo "<pre>";
    print_r(json_encode($items));
    // echo "</pre>";

    /**
     * Generate csv file
     */
    $csv_file = fopen('test.csv', 'w');
    
    // Header
    fputcsv($csv_file, $item_attributes);
    // Data
    foreach ($items as $item) {
        fputcsv($csv_file, $item, ";");
    }

    fclose($csv_file);
}