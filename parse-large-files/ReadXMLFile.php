<?php

class ReadXMLFile
{
    /**
     * @var string $url path to xml fule
     */
    protected $url;

    /**
     * @var array $attributes values of the attributes that are ruquired in the output
     */
    protected $attributes;

    /**
     * @var array $nodes names of nodes which values are required in the ourput
     */
    protected $nodes;

    /**
     * @var string $node_name
     */
    protected $node_name;

    /**
     * @var XMLReader $xml
     */
    protected $xml;

    /**
     * @var string $output_format
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

    public function iterateThroughNodes()
    {
        $this->xml->open($this->url);

        //todo: what this lones is doing?
        while ($this->xml->read() && $this->xml->name != $this->node_name) {
        }

        $k = 0;
        while ($this->xml->name == $this->node_name) {
            $element = new SimpleXMLElement($this->xml->readOuterXML());
            for ($i = 0; $i < count($this->attributes); $i++) {
                $files[$k][$this->attributes[$i]] = strval($element->attributes()->{$this->attributes[$i]});
            }
            //todo: layout is not good
            for ($i = 0; $i < count($this->nodes); $i++) {
                $files[$k][$this->nodes[$i]] = $element->{$this->nodes[$i]};
            }

            $k++;
            $this->xml->next($this->node_name);
        }

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
