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

    protected $node_values = [];


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

            
            // Final solution but features have no value
            for ($i = 0; $i < count($this->nodes); $i++) {
                if ($element->{$this->nodes[$i]}->count() > 0) {
                    $node = $element->{$this->nodes[$i]};
                    $countryMarkets = [];

                    /**
                     * //------ Deleted contents -------//
                     */
                    $str = '--string';
                    if (count($node) > 0) {
                        foreach ($node as $a => $parent) {
                            if (count($parent) > 0) {
                                foreach ($parent as $b => $child) {
                                    if (count($child) > 0) {
                                        foreach ($child as $c => $grandchild) {
                                            if (count($grandchild) > 0) {
                                                foreach ($grandchild as $d => $grandgrandchild) {
                                                    $countryMarkets[] = (string)$grandgrandchild . 'GRAND GRAND CHILD';
                                                }
                                            } else {
                                                if ($this->node_attribute) {
                                                    $countryMarkets[] = (string)$grandchild->attributes()['Value'] . $str; // Hard coded
                                                } else {
                                                    $countryMarkets[] = (string)$grandchild;
                                                }
                                                // $countryMarkets[] = (string)$grandchild . 'ELSE GRAND CHILD';
                                            }
                                        }
                                    } else {
                                        if ($this->node_attribute) {
                                            $countryMarkets[] = (string)$child->attributes()['Value'] . $str; // Hard coded
                                        } else {
                                            $countryMarkets[] = (string)$child;
                                        }
                                        // $countryMarkets[] = (string)$child . 'ELSE CHILD';
                                    }
                                }
                            } else {
                                if ($this->node_attribute) {
                                    $countryMarkets[] = (string)$parent->attributes()['Value'] . $str; // Hard coded
                                } else {
                                    $countryMarkets[] = (string)$parent;
                                }
                                // $countryMarkets[] = (string)$child . 'ELSE PARENT';
                            }
                        }
                    } else {
                        // foreach ($node->children() as $child) {
                        if ($this->node_attribute) {
                                // if (count($node) > 1) {
                            $countryMarkets[] = (string)$node->attributes()['Value'] . $str; // Hard coded
                        } else {
                            $countryMarkets[] = (string)$node;
                        }
                        // }
                    }

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

        $str = '------factorialNode';
        if (count($node) > 0) {
            foreach ($node as $a => $parent) {
                // Here repeating is beginning
                // var_dump(count($parent));
                $this->factorialNode($parent);
                // die;
            }
        } else {
            if ($this->node_attribute) {
                $this->node_values[] = (string)$node->attributes()['Value'] . $str; // Hard coded
            } else {
                $this->node_values[] = (string)$node;
            }
        }
        // var_dump($node_values);
        return $this->node_values;
    }

}
