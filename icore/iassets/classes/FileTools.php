<?php

class FileTools extends StorageTools
{
    private $FileAddress;
    public function __construct($FileFullAddress)
    {
        $this->FileAddress = $FileFullAddress;
    }

    public function KeyValueFileReader()
    {
        $arrAllContent = array();

        foreach (file($this->FileAddress) as $line ) {
            $arrGenerate = explode("::==::",trim($line));
            $arrAllContent[$arrGenerate[0]] = $arrGenerate[1];
        }
        return $arrAllContent;
    }
}