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
    protected $output_format = 'JSON';

    /**
     * @var boolean $node_attribute | whether the value has taken from node's attribute or from node.
     */
    protected $node_attribute;

    /**
     * @var array $node_values | contains the value from nodes
     */
    protected $node_values = [];

    /**
     * @var array $attribute_values
     */
    protected $attribute_values;

    /**
     * @var boolean $attribute_filter
     */
    protected $attribute_filter = false;

    public function __construct(
        string $url,
        array $attributes = [],
        array $nodes = [],
        string $node_name = '',
        string $output_format,
        $node_attribute = null,
        array $attribute_values
    ) {
        $this->url = $url;
        $this->attributes = $attributes;
        $this->nodes = $nodes;
        $this->node_name = $node_name;
        if ($output_format != '') {
            $this->output_format = $output_format;
        }
        $this->node_attribute = $node_attribute;
        $this->attribute_values = $attribute_values;
        $this->xml = new XMLReader();
    }

    /**
     * Loop through every node
     * The solution is pretty general. I tested on several files and it works more or less accurate.
     */
    public function iterateThroughNodes()
    {
        $this->xml->open($this->url);

        // move to the first <file /> node
        while ($this->xml->read() && $this->xml->name != $this->node_name) {
        }

        $k = 0;
        while ($this->xml->name == $this->node_name) {
            $element = new SimpleXMLElement($this->xml->readOuterXML());

            // This loop pull out the values from attributes
            for ($i = 0; $i < count($this->attributes); $i++) {
                $files[$k][$this->attributes[$i]] = strval($element->attributes()->{$this->attributes[$i]});
            }

            // Extract data from node values
            for ($i = 0; $i < count($this->nodes); $i++) {
                if ($element->{$this->nodes[$i]}->count() > 0) {
                    $node = $element->{$this->nodes[$i]};

                    /**
                     * //------ Deleted contents -------//
                     */

                    $files[$k][$this->nodes[$i]][(string)$element->{$this->nodes[$i]}->attributes()->type] = $this->factorialNode($node);
                    $this->node_values = [];
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
        //todo: here can be implemented solution for deciding how deep the loop go into the tree level
        // current solution roll out every value from considered node, even the deepest one and put that value in $node_values array

        $str = '------factorialNode'; // for orientation
        if (count($node) > 0) {
            foreach ($node as $a => $parent) {
                $this->factorialNode($parent);
            }
        } else {
            if ($this->node_attribute) {
                $this->node_values[] = (string)$node->attributes()['Value'] . $str; // Hard coded value for required output Country_Market, EAN_UPCS. Every node can have different names of attributes. So this can be implemented as an option but it would have a lot of options and that leads to the whole project or micro framework.
            } else {
                // $this->node_values[$node->attributes()->type] = (string)$node;
                $this->node_values[] = (string)$node;
            }
        }

        return $this->node_values;
    }

}
