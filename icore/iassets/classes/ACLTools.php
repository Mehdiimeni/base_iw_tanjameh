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

    public function NormalLogin($FullAddressLoginLogFile, $UserType = 'admin'): bool
    {
        if($UserType == 'user') {
            if (@$this->jsonSessionVars->_IWUserIdKey == NULL) {

                if (@$this->jsonCookieVars->_IWUserIdKey == NULL) {

                    return true;


                } else {
                    return false;
                }

            } else {
                return false;
            }
        }else
        {
            if (@$this->jsonSessionVars->_IWAdminIdKey == NULL) {
                if (@$this->jsonCookieVars->_IWAdminIdKey == NULL) {
                    return true;

                } else {
                    return false;
                }

            } else {
                return false;
            }
        }

    }

    public function NormalUserLogin($FullAddressLoginLogFile): bool
    {
        if (@$this->jsonSessionVars->_IWUserIdKey == NULL) {

            if (@$this->jsonCookieVars->_IWUserIdKey == NULL) {

                    return true;


            } else {
                return false;
            }

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