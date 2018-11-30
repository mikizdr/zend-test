<?php

class FilterXml
{
    /**
     * @var 
     */
    protected $tag;

    /**
     * @var 
     */
    protected $value;

    /**
     * @var 
     */
    protected $xmlFile;


    public function __construct($tag, $value)
    {
        $this->tag = $tag;
        $this->value = $value;
    }

    public function getFile()
    {;
    }
}
