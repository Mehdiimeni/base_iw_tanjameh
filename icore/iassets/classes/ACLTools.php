<?php

class ACLTools extends GlobalVarTools
{

    private $jsonSessionVars;
    private $jsonCookieVars;

    public function __construct()
    {
        parent::__construct();
        $this->jsonSessionVars = parent::JsonDecode(parent::SessionVarToJson());
        $this->jsonCookieVars = parent::JsonDecode(parent::CookieVarToJson());

    }

    public function CookieCheck($UserType)
    {
        if ($UserType == 'admin') {

            if (@$this->jsonCookieVars->_IWAdminIdKey != null) {
                parent::setSessionVar('_IWAdminIdKey', parent::de2Base64($this->jsonCookieVars->_IWAdminIdKey));
                return true;

            } else {
                return false;
            }

        }

        if ($UserType == 'user') {

            if (@$this->jsonCookieVars->_IWUserIdKey != null) {
                parent::setSessionVar('_IWUserIdKey', parent::de2Base64($this->jsonCookieVars->_IWUserIdKey));
                return true;

            } else {
                return false;
            }

        }
    }

    public function NormalLogin($FullAddressLoginLogFile, $UserType = 'admin'): bool
    {
        if (file_exists($FullAddressLoginLogFile)) {
            return $this->CookieCheck($UserType);
        } else {
            return false;
        }
    }


    public function TableNames()
    {
        return AllTable;
    }

    public function RmTableNames($tableName)
    {
        return array_diff(AllTable, array($tableName));
    }

    public function CheckNull($StdClassArray): bool
    {
        $array = parent::JsonDecodeArray($StdClassArray);
        if (count(array_filter($array)) == count($array)) {
            return false;
        } else {
            return true;
        }


    }

    public function CheckNullExcept($StdClassArray, array $arrExcept): bool
    {
        $arrayAll = parent::JsonDecodeArray($StdClassArray);


        $arrayAll = array_diff($arrayAll, $arrExcept);
        if (count(array_filter($arrayAll)) == count($arrayAll)) {
            return false;
        } else {
            return true;
        }


    }


}