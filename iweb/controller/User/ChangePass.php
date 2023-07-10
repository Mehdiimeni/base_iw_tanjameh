<?php
//ChangePass.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$objGlobalVar = new GlobalVarTools();
$Enabled = true;

$UserId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));

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


        $Enabled = true;


        require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";


        $objTimeTools = new TimeTools();
        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        
        


        $now_modify = date("Y-m-d H:i:s");

        $UCondition = " IdKey = '$UserId'";

        $USet = "";
        $USet .= " Password = '$PasswordL' ,";
        $USet .= " ChangePass = '0' ,";
        $USet .= " modify_ip = '$modify_ip' ,";
        
        
        $USet .= " last_modify = '$now_modify' ,";
        $USet .= " ModifyId = '$UserId' ";

        $objORM->DataUpdate($UCondition, $USet, TableIWUser);


        $objGlobalVar = new GlobalVarTools();
        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;

        JavaTools::JsAlertWithRefresh(FA_LC['pass_reset_body'], 0, '');
        exit();

    }


}

