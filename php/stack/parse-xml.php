<?php

class SimpleDMOZParser
{
    protected $_stack = array();
    protected $_file = "";
    protected $_parser = null;

    protected $_currentId = "";
    protected $_current = "";

    public function __construct($file)
    {
        $this->_file = $file;

        $this->_parser = xml_parser_create("UTF-8");
        xml_set_object($this->_parser, $this);
        xml_set_element_handler($this->_parser, "startTag", "endTag");
    }

    public function startTag($parser, $name, $attribs)
    {
        array_push($this->_stack, $this->_current);

        if ($name == "TOPIC" && count($attribs)) {
            $this->_currentId = $attribs["R:ID"];
        }

        if ($name == "LINK" && strpos($this->_currentId, "Top/Home/Consumer_Information/Electronics/") === 0) {
            echo $attribs["R:RESOURCE"] . "\n";
        }

        $this->_current = $name;
    }

    public function endTag($parser, $name)
    {
        $this->_current = array_pop($this->_stack);
    }

    public function parse()
    {
        $fh = fopen($this->_file, "r");
        if (!$fh) {
            die("Epic fail!\n");
        }

        while (!feof($fh)) {
            $data = fread($fh, 4096);
            xml_parse($this->_parser, $data, feof($fh));
        }
    }
}

$parser = new SimpleDMOZParser("content.rdf.u8");
$parser->parse();