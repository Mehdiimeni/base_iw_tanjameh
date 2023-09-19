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
            if (@$this->jsonCookieVars->_IWAdminId != null) {
                parent::setSessionVar('_IWAdminId', parent::de2Base64($this->jsonCookieVars->_IWAdminId));
                return true;
            } else {
                return false;
            }
        }

        if ($UserType == 'user') {
            if (@$this->jsonCookieVars->user_id != null) {
                parent::setSessionVar('user_id', parent::deBase64($this->jsonCookieVars->user_id));
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
        return count(array_filter($array)) !== count($array);
    }

    public function CheckNullExcept($StdClassArray, array $arrExcept): bool
    {
        $arrayAll = parent::JsonDecodeArray($StdClassArray);
        $arrayAll = array_diff($arrayAll, $arrExcept);
        return count(array_filter($arrayAll)) !== count($arrayAll);
    }
}
