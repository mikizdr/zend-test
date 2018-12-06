<?php

class CustomException extends Exception
{
    public function errorMessage()
    {
        $errorMessage = 'Error on line ' . $this->getLine() . ' in ' . $this->getFile()
            . ': <b>' . $this->getMessage() . '</b> is not a valid URL to an XML fule.';
        return $errorMessage;
    }
}