<?php

/**
 * This is the main class for parsing an XML file and to process the data from it.
 * The main point is __construct method where everything is prepared for parsing and extracting the data.
 * XMLReader is used because of dealing with huge XML files. The reader acts as a cursor going forward on 
 * the document stream and stopping at each node on the way.
 * The SimpleXML extension provides a very simple and easily usable toolset to convert XML to an 
 * object that can be processed with normal property selectors and array iterators.
 * 
 * @category   XML
 * @link       SimpleXMLElement class http://php.net/manual/en/class.simplexmlelement.php
 * @link       XMLReader http://php.net/manual/en/book.xmlreader.php  
 * @author     Mirosalv Zdravkovic <mirosalv.zdravkovic@gmail.com>
 */
class ReadXMLFile extends Exception
{
    /**
     * @var string $url | path to xml file
     */
    protected $url;

    /**
     * @var array $attributes | values of the attributes that are re:-)quired in the output
     */
    protected $attributes;

    /**
     * @var array $nodes | names of nodes which values are required in the output
     */
    protected $nodes;

    /**
     * @var string $nodeName | name od the main node (so for this case - file)
     */
    protected $nodeName;

    /**
     * @var XMLReader $xml | used to parse large XML files. It walks node by node.
     */
    protected $xml;

    /**
     * @var string $outputFormat | JSON, csv, txt, print_r, ....
     */
    protected $outputFormat = 'JSON';

    /**
     * @var boolean $nodeAttribute | whether the value has taken from node's attribute or from node.
     */
    protected $nodeAttribute;

    /**
     * @var array $nodeValues | contains the value from nodes
     */
    protected $nodeValues = [];

    /**
     * @var array $attributeName | The name of attribute for filtering data. NOTE: this can be an array
     */
    protected $attributeName = 'Catid';

    /**
     * @var array $attributeValues | values for attributes by which the data are filtered
     */
    protected $attributeValues;

    /**
     * @var string $attributeFilter | Decides whether the data will be filtered
     */
    protected $attributeFilter = false;

    /**
     * @var array $outputArray
     */
    protected $outputArray = [];

    public function __construct(
        string $url,
        array $attributes = [],
        array $nodes = [],
        string $nodeName = '',
        string $outputFormat,
        $nodeAttribute = null,
        string $attributeName = '',
        array $attributeValues = [],
        $attributeFilter = ''
    ) {
        $this->url = $url;
        $this->attributes = $attributes;
        $this->nodes = $nodes;
        $this->nodeName = $nodeName;
        if ($outputFormat != '') {
            $this->outputFormat = $outputFormat;
        }
        $this->nodeAttribute = $nodeAttribute;
        $this->attributeName = $attributeName;
        $this->attributeValues = $attributeValues;
        $this->attributeFilter = $attributeFilter;
        $this->xml = new XMLReader();
    }

    /**
     * Loop through every node.
     * The solution is pretty general. I tested on several files and it works more or less accurate.
     */
    public function iterateThroughNodes()
    {
        try {
            if (empty($this->url) || is_null($this->url)) {
                throw new Exception($this->errorMessage());
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $this->xml->open($this->url);

        // Move to the first <file /> node
        while ($this->xml->read() && $this->xml->name != $this->nodeName) {
        }

        $k = 0;
        while ($this->xml->name == $this->nodeName) {
            $element = new SimpleXMLElement($this->xml->readOuterXML());

            // This loop pull out the values from attributes
            for ($i = 0; $i < count($this->attributes); $i++) {
                $files[$k][$this->attributes[$i]] = strval($element->attributes()->{$this->attributes[$i]});
            }

            // Extract data from node values
            for ($i = 0; $i < count($this->nodes); $i++) {
                if ($element->{$this->nodes[$i]}->count() > 0) {
                    $currentNode = $element->{$this->nodes[$i]};
                    $files[$k][$this->nodes[$i]] = $this->factorialNode($currentNode);
                    // Reset nodeValues array to an empty array because of the next iteration
                    $this->nodeValues = [];
                }
            }

            // Incremetn iterator and go to the next node
            $k++;
            $this->xml->next($this->nodeName);
        }

        // Store the result in outputArray because of later manipulating with extracted array
        $this->outputArray = $files;

        // Check condition and if so, filter the data
        if ($this->attributeFilter) {
            return $this->filterData();
        }
        return $this->outputArray;
    }

    /**
     * Decide the output format
     */
    public function printResult()
    {
        if ($this->outputFormat == 'JSON') {
            echo json_encode($this->iterateThroughNodes());
        } elseif ($this->outputFormat == 'csv') {
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
        $csvFile = fopen('test.csv', 'w');
        // Header
        fputcsv($csvFile, array_merge($this->attributes, $this->nodes));
        // Data
        foreach ($this->iterateThroughNodes() as $item) {
            foreach ($item as $key => $value) {
                if (is_array($value)) {
                    $item[$key] = implode(', ', $value);
                }
            }
            fputcsv($csvFile, $item, ";");
        }
        fclose($csvFile);
    }

    /**
     * Fliter data by certain criteria
     */
    public function filterData()
    {
        $filteredArray = [];
        foreach ($this->outputArray as $key => $value) {
            foreach ($this->attributeValues as $attrValue) {
                if ($value[$this->attributeName] == $attrValue) {
                    $filteredArray[] = $value;
                }
            }
        }
        return $filteredArray;
    }

    /**
     * @param SimpleXMLElement $node
     */
    public function factorialNode(SimpleXMLElement $node)
    {
        //todo: here can be implemented solution for deciding how deep the loop go into the tree level
        // current solution roll out every value from considered node, even the deepest one and put that value in $nodeValues array

        if (count($node) > 0) {
            foreach ($node as $key => $value) {
                $this->factorialNode($value);
            }
        } else {
            if ($this->nodeAttribute) {
                $this->nodeValues[] = strval($node->attributes()['Value']); // Hard coded value for required output Country_Market, EAN_UPCS. Every node can have different names of attributes. So this can be implemented as an option but it would have a lot of options and that leads to the whole project or micro framework.
            } else {
                $this->nodeValues[] = strval($node);
                // $this->nodeValues[] = (string)$node;
            }
        }

        return $this->nodeValues;
    }

    /**
     * Exception handler method
     */
    public function errorMessage()
    {
        $message = '<strong>Error on line ' . $this->getLine() . ' in ' . $this->getFile() . ': this is not a valid URL to an XML file.</strong>';
        return $message;
    }
}
