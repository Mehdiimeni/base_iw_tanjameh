<?php

class InitTools extends GlobalVarTools
{
    private $Memory;
    private $Errors;
    private $Lang;
    private $TimeZone;
    private $Encoding;

    private $jsonServerVars;

    public function __construct(array $array, $FullErrorPartAddressRepository)
    {
        parent::__construct();
        $this->jsonServerVars = parent::JsonDecode(parent::ServerVarToJson());

        $this->setMemoryLimit($array['MemoryLimit']);
        $this->setLang($array['Language']);
        $this->setTimeZone($array['TimeZone']);
        $this->setEncoding($array['Encoding']);
        $this->CheckHandler($FullErrorPartAddressRepository);


    }

    public function IniSet($option, $value)
    {

        ini_set($option, $value);

    }

    public function setMemoryLimit($MemoryLimit)
    {
        $this->Memory = $MemoryLimit;
        $this->IniSet("memory_limit", $this->Memory);
    }

    public function getMemoryLimit()
    {
        return $this->Memory;
    }

    public function setDisplayErrors($DisplayErrors)
    {
        $this->Errors = $DisplayErrors;
        $DisplayErrors == 1 ? $Reporting = "E_ALL" : $Reporting = $this->Errors;

        //error_reporting($Reporting);
        $this->IniSet("display_errors", $this->Errors);

    }

    public function getDisplayErrors()
    {
        return $this->Errors;
    }

    public function setLang($Language)
    {
        $this->Lang = $Language;
        if (!defined("GENERAL_LANGUAGE"))
            define("GENERAL_LANGUAGE", $this->Lang);
    }

    public function getLang()
    {
        return $this->Lang;
    }

    public function getLanguageDirection()
    {
        if (array_search(strtolower($this->Lang), array('fa', 'ar')) == false) {
            return 'rtl';
        } else {
            return 'ltr';
        }
    }

    public function setTimeZone($LocalTimeZone)
    {
        $this->TimeZone = $LocalTimeZone;
        date_default_timezone_set($this->TimeZone);
    }

    public function getTimeZone()
    {
        return $this->TimeZone;
    }

    public function setEncoding($GeneralEncode)
    {
        $this->Encoding = $GeneralEncode;
        mb_internal_encoding($this->Encoding);
        mb_http_output($this->Encoding);
    }

    public function getEncoding()
    {
        return $this->Encoding;
    }

    public function CheckHandler($FullErrorPartAddressRepository)
    {
        $this->jsonServerVars->HTTP_HOST == 'localhost' ? $this->setDisplayErrors(1) : $this->setDisplayErrors(1);
        $this->IniSet("log_errors", true);
        $this->IniSet("error_log", $FullErrorPartAddressRepository);

    }

}
