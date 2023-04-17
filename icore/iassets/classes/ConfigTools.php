<?php

class ConfigTools
{

    private $AllConfigFileList;
    private $DefineRoot;
    private $Stoper;

    public function __construct($DefineRoot)
    {
        $this->AllConfigFileList = array('init.iw', 'key.iw', 'host.iw', 'local.iw', 'online.iw', 'ipallow.txt', 'ipdeny.txt');
        $this->DefineRoot = $DefineRoot;
        $this->Stoper = 0;
    }

    public function CheckConfigFileExist()
    {
        foreach ($this->AllConfigFileList as $ConfigFile) {
            if (!file_exists($this->DefineRoot . 'conf/' . $ConfigFile)) {
                $strFileName = explode(".", $ConfigFile);
                require_once $this->DefineRoot . 'set/' . $strFileName[0] . '.php';
                $this->Stoper = 1;
                exit();
            } else {
                $this->Stoper = 0;
            }
        }
    }

    public function StoperCheck($StoperCheck)
    {
        if ($this->Stoper == 1 or $StoperCheck == 1)
            $this->CheckConfigFileExist();
    }


}