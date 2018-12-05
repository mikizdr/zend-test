<?php

/**
 * This is the main class
 * 
 */
class ReadXMLFile
{
    /**
     * @var string $url path to xml file
     */
    protected $url;

    /**
     * @var array $attributes values of the attributes that are re:-)quired in the output
     */
    protected $attributes;

    /**
     * @var array $nodes names of nodes which values are required in the output
     */
    protected $nodes;

    /**
     * @var string $node_name name od the main node (so for this case - file)
     */
    protected $node_name;

    /**
     * @var XMLReader $xml - used to parse large XML files. It walks node by node.
     */
    protected $xml;

    /**
     * @var string $output_format | JSON, csv, txt, print_r, ....
     */
    protected $output_format;

    /**
     * @var boolean $node_attribute | whether the value has taken from node's attribute or from node.
     */
    protected $node_attribute;


    public function __construct(
        string $url,
        array $attributes = [],
        array $nodes = [],
        string $node_name = '',
        string $output_format = 'JSON',
        $node_attribute = null
    ) {
        $this->url = $url;
        $this->attributes = $attributes;
        $this->nodes = $nodes;
        $this->node_name = $node_name;
        $this->output_format = $output_format;
        $this->node_attribute = $node_attribute;
        $this->xml = new XMLReader();
    }

    /**
     * Loop through every node
     * The solution is pretty general. I tested on several files and it works more or less accurate.
     */
    public function iterateThroughNodes()
    {
        $this->xml->open($this->url);

        //todo: what this line is doing?
        /**
         * This is the strange thing. Without this line, script breaks.
         */
        // move to the first <file /> node
        while ($this->xml->read() && $this->xml->name != $this->node_name) {
        }

        // var_dump($this->xml->name);
        $k = 0;
        while ($this->xml->name == $this->node_name) {
            $element = new SimpleXMLElement($this->xml->readOuterXML());

            // This loop pull out the values for attributes
            for ($i = 0; $i < count($this->attributes); $i++) {
                $files[$k][$this->attributes[$i]] = strval($element->attributes()->{$this->attributes[$i]});
            }

            // This loop reads value for every node and child of that node
            // for ($i = 0; $i < count($this->nodes); $i++) {
            //     if ($element->{$this->nodes[$i]}->count() > 0) {
            //         $node = $element->{$this->nodes[$i]};

            //         $countryMarkets = [];

            //         foreach ($node->children() as $child) {
            //             if ($this->node_attribute) {
            //                 $countryMarkets[] = (string)$child->attributes()['Value'];
            //             } else {
            //                 $countryMarkets[] = (string)$child;
            //             }
            //         }

            //         $files[$k][$this->nodes[$i]] = $countryMarkets;
            //     }
            // }
            $str = 'features?';
            // Final solution but features have no value
            for ($i = 0; $i < count($this->nodes); $i++) {
                if ($element->{$this->nodes[$i]}->count() > 0) {
                    $node = $element->{$this->nodes[$i]};

                    $countryMarkets = [];
                    $this->factorialNode($node);
                    // if (count($node) > 1) {
                    //     foreach ($node as $a => $iteration) {
                    //         if (count($iteration) > 1) {
                    //             echo ('<h1>Iteration ' . $a . ' ' . count($iteration)) . '</h1>';
                    //             foreach ($iteration as $b => $child) {
                    //             // for ($m = 0; $m < count($iteration); $m++) {
                    //                 echo ('<h1>Child ' . $b . ' ' . count($child)) . '</h1>';
                    //                 // if (count($child) > 1) {
                    //                 //     foreach ($child as $c => $kid) {
                    //                 //         $countryMarkets[][$c] = (string)$kid . 'KIDMILKA';
                    //                 $kukuriku = [];
                    //                 //     }
                    //                 // } else {
                    //                 // var_dump($child);
                    //                 $kukuriku[] = (string)$child . 'CHILDMILKA';
                    //                 // $countryMarkets[][strval($child->attributes()->lang)] = (string)$child . 'CHILDMILKA';
                    //                 // }
                    //             }
                    //             echo ('<h1>KUKURIKU: ' . count($kukuriku) . '</h1>');
                    //             $countryMarkets[] = $kukuriku;
                    //         } else {
                    //             foreach ($iteration as $key => $child) {
                    //                 echo ('<h1>Else ' . $a . ' ' . count($iteration)) . '</h1>';
                    //                 if (count($child) > 1) {
                    //                     foreach ($iteration as $key => $kid) {
                    //                         $countryMarkets[] = (string)$kid . 'KIDlea';
                    //                     }
                    //                 } else {
                    //                     $countryMarkets[] = (string)$child . 'iterationlea';
                    //                 }
                    //             }
                    //         }
                    //     }
                    // } else {
                    //     foreach ($node->children() as $child) {
                    //         if ($this->node_attribute) {
                    //             // if (count($node) > 1) {
                    //             $countryMarkets[] = (string)$child->attributes()['Value'] . $str; // Hard coded
                    //         } else {
                    //             $countryMarkets[] = (string)$child;
                    //         }
                    //     }
                    // }



                    // if (count($node) > 1) {
                    //     foreach ($node as $a => $iteration) {
                    //         if (count($iteration) > 1) {
                    //             echo ('<h1>Iteration ' . $a . ' ' . count($iteration)) . '</h1>';
                    //             foreach ($iteration as $b => $child) {
                    //                 // echo ('<h1>Child ' . $b . ' ' . count($child)) . '</h1>';
                    //                 // if (count($child) > 1) {
                    //                 //     foreach ($child as $c => $kid) {
                    //                 //         $countryMarkets[][$c] = (string)$kid . 'KIDMILKA';
                    //                 //     }
                    //                 // } else {
                    //                 // var_dump($child);
                    //                 $countryMarkets[][$child->getName()] = (string)$child . 'CHILDMILKA';
                    //                 // $countryMarkets[][strval($child->attributes()->lang)] = (string)$child . 'CHILDMILKA';
                    //                 // }
                    //             }
                    //         } else {
                    //             foreach ($iteration as $key => $child) {
                    //                 echo ('<h1>Else ' . $a . ' ' . count($iteration)) . '</h1>';
                    //                 if (count($child) > 1) {
                    //                     foreach ($iteration as $key => $kid) {
                    //                         $countryMarkets[] = (string)$kid . 'KIDlea';
                    //                     }
                    //                 } else {
                    //                     $countryMarkets[][$child->getName()] = (string)$child . 'iterationlea';
                    //                 }
                    //             }
                    //         }
                    //     }
                    // } else {
                    //     foreach ($node->children() as $child) {
                    //         if ($this->node_attribute) {
                    //             // if (count($node) > 1) {
                    //             $countryMarkets[] = (string)$child->attributes()['Value'] . $str; // Hard coded
                    //         } else {
                    //             $countryMarkets[] = (string)$child;
                    //         }
                    //     }
                    // }
                    $files[$k][$this->nodes[$i]] = $countryMarkets;
                }
            }

            $k++;
            $this->xml->next($this->node_name);
        }
        // I have 4 file nodes in tested XML file
        return $files;
    }

    /**
     * Decide the output format
     */
    public function printResult()
    {
        if ($this->output_format == 'JSON') {
            echo json_encode($this->iterateThroughNodes());
        } elseif ($this->output_format == 'csv') {
            $this->generateCsv();
        } else {
            print_r($this->iterateThroughNodes());
        }
    }

    /**
     * Generate csv file
     */
    public function generateCsv()
    {
        $csv_file = fopen('test.csv', 'w');
        // Header
        fputcsv($csv_file, $this->attributes);
        // Data
        foreach ($this->iterateThroughNodes() as $item) {
            fputcsv($csv_file, $item, ";");
        }
        fclose($csv_file);
    }

    /**
     * Fliter data by certain criteria
     */
    public function filterData()
    {
        return;
    }

    /**
     * @param SimpleXMLElement $node
     */
    public function factorialNode(SimpleXMLElement $node)
    {
        $node_values = [];
        foreach ($node as $key => $value) {
            if (count($value) > 0) {
                $this->factorialNode($value);
            } else {
                $node_values[] = (string)$node;
            }
        }
        return $node_values;
    }

    public function factorial($n)
    {
 
        // Base case
        if ($n == 0) {
            echo "Base case: \$n = 0. Returning 1...<br>";
            return 1;
        }
       
        // Recursion
        echo "\$n = $n: Computing $n * factorial( " . ($n - 1) . " )...<br>";
        $result = ($n * $this->factorial($n - 1));
        echo "Result of $n * factorial( " . ($n - 1) . " ) = $result. Returning $result...<br>";
        return $result;
    }
}
