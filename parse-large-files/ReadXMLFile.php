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


    public function __construct(
        string $url = '',
        array $attributes = [],
        array $nodes = [],
        string $node_name = '',
        string $output_format = 'JSON'
    ) {
        $this->url = $url;
        $this->attributes = $attributes;
        $this->nodes = $nodes;
        $this->node_name = $node_name;
        $this->output_format = $output_format;
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
            for ($i = 0; $i < count($this->nodes); $i++) {
                if ($element->{$this->nodes[$i]}->count() > 0) {
                    $node = $element->{$this->nodes[$i]};

                    $countryMarkets = [];

                    if (count($node) > 1) {
                        foreach ($node as $key => $iteration) {
                            foreach ($iteration as $key => $child) {
                                $countryMarkets[] = (string)$child;
                            }
                        }
                    } else {
                        foreach ($node->children() as $child) {
                            $attributes = $child;
                            // $attributes = $child->attributes();
                            $countryMarkets[] = (string)$attributes;
                            // $countryMarkets[] = (string)$attributes['Value'];
                        }
                    }

                    $files[$k][$this->nodes[$i]] = $countryMarkets;
                }
            }
            //todo: BUT layout is not good
            // for ($i = 0; $i < count($this->nodes); $i++) {
            //     if ($element->{$this->nodes[$i]}->count() > 0) {
            //         // This gives the next output
            //         $files[$k][$this->nodes[$i]] = $element->{$this->nodes[$i]}; // So I need to iterate through this value: $element->{$this->nodes[$i]};
            //         // it's not an array . There must be a method to get the node children. Something like ->childre() ?
            //         // var_dump($element->{$this->nodes[$i]}); // You see? Pretty the same.
            //         foreach ($element->{$this->nodes[$i]}->children() as $key => $value) {
            //             $files[$k][$this->nodes[$i]] = strval($value->attributes());
            //             // echo '<h3>' . strval($value->attributes()) . '</h3>';
            //         }
            //     }
                // That's why I tried in this way:
                // if ($element->{$this->nodes[$i]}->count() > 0) {
                //     $files[$k][$this->nodes[$i]] = function () {
                // foreach ($element->{$this->nodes[$i]}->children() as $key => $value) {
                //     return $value;
                //             // return strval($value->attributes());
                // }
                // // return $element->{$this->nodes[$i]};
                //     };
                // }
            // }

            // With closures, this shows the whole object?!
            // if ($element->{$this->nodes[$i]}->count() > 0) {
            //     $files[$k][$this->nodes[$i]] = function () {
            //         foreach ($element->{$this->nodes[$i]}->children() as $key => $value) {
            //             return strval($value->attributes());
            //         }
            //         // return $element->{$this->nodes[$i]};
            //     };
            // }

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
}
