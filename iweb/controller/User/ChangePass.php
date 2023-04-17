<?php
//ChangePass.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$objGlobalVar = new GlobalVarTools();
$Enabled = BoolEnum::BOOL_TRUE();

$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

if (isset($_POST['RegisterE'])) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);
        $RePasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->RePassword, 0);

        if ($PasswordL != $RePasswordL) {
            JavaTools::JsAlertWithRefresh(FA_LC['repeat_passwords_error'], 0, '');
            exit();
        }


        $Enabled = BoolEnum::BOOL_TRUE();


        include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";


        $objTimeTools = new TimeTools();
        $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $ModifyTime = $objTimeTools->jdate("H:i:s");
        $ModifyDate = $objTimeTools->jdate("Y/m/d");


        $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;

        $UCondition = " IdKey = '$UserIdKey'";

        $USet = "";
        $USet .= " Password = '$PasswordL' ,";
        $USet .= " ChangePass = '0' ,";
        $USet .= " ModifyIP = '$ModifyIP' ,";
        $USet .= " ModifyTime = '$ModifyTime' ,";
        $USet .= " ModifyDate = '$ModifyDate' ,";
        $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
        $USet .= " ModifyId = '$UserIdKey' ";

        $objORM->DataUpdate($UCondition, $USet, TableIWUser);


        $objGlobalVar = new GlobalVarTools();
        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;

        JavaTools::JsAlertWithRefresh(FA_LC['pass_reset_body'], 0, '');
        exit();

    }


}

