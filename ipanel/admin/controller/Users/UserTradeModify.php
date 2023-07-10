<?php
//UserTradeModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
$Enabled = true;

switch ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify) {
    case 'add' :
        $strModifyTitle = FA_LC["add"];
        break;
    case 'edit' :
        $strModifyTitle = FA_LC["edit"];
        break;
    case 'view' :
        $strModifyTitle = FA_LC["view"];
        break;
}

//Group Name
$strGroupIdKey = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWUserGroup) as $ListItem) {
    $strGroupIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}
//All Trade
$SCondition = " Enabled = $Enabled ORDER BY id ";

$strAllTrade = '';
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWTradeGroup) as $ListItem) {
    $strAllTrade .= '<optgroup  label=' . $ListItem->Name . '>';

    $SCondition = " Enabled = $Enabled AND GroupIdKey = $ListItem->id  ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWTrade) as $ListItem2) {
        $strAllTrade .= '<option value=' . $ListItem->id . ';' . $ListItem2->id . '>';
        $strAllTrade .= $ListItem2->Name;
        $strAllTrade .= '</option>';

    }
    $strAllTrade .= '</optgroup>';
}


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {

    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson()) or $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTrade == null ) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $AllTrade = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTrade;

        $Enabled = true;
        $SCondition = "  GroupIdKey = '$GroupIdKey' and AllTrade != ''  ";

        if ($objORM->DataExist($SCondition, TableIWUserAccess)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            foreach ($AllTrade as $access) {

                $expStr = explode(";", $access);
                $arrStr[$expStr[0]][] = $expStr[1];

            }
            $jsonAllTrade = $objAclTools->JsonEncode($arrStr);

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $UCondition = " GroupIdKey = '$GroupIdKey' ";
            $USet = "";
            $USet .= " AllTrade = '$jsonAllTrade' ,";
            $USet .= " modify_ip = '$modify_ip' ,";
            
            
            $USet .= " last_modify = '$now_modify' ,";
            $USet .= " modify_id = $ModifyId ";

            $objORM->DataUpdate($UCondition, $USet, TableIWUserAccess);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'AllTrade,GroupIdKey', TableIWUserAccess);

    //Part Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWUserGroup);
    $strGroupIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';


    //All Trade
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    $arrExitViewTrade = ($objGlobalVar->JsonDecodeArray($objEditView->AllTrade));
    $strAllTrade = '';
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWTradeGroup) as $ListItem) {
        $strAllTrade .= '<optgroup  label=' . $ListItem->Name . '>';

        $SCondition = " Enabled = $Enabled AND GroupIdKey = $ListItem->id  ORDER BY id ";
        foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWTrade) as $ListItem2) {
            $selected = '';
            if (isset($arrExitViewTrade[$ListItem->id]))
                if (array_search($ListItem2->id, $arrExitViewTrade[$ListItem->id]) > -1)
                    $selected = 'selected';

            $strAllTrade .= '<option value=' . $ListItem->id . ';' . $ListItem2->id . ' ' . $selected . ' >';
            $strAllTrade .= $ListItem2->Name;
            $strAllTrade .= '</option>';

        }
        $strAllTrade .= '</optgroup>';

    }


    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson()) or @$objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTrade == null ) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
            $AllTrade = $objAclTools->JsonDecode($objAclTools->PostVarToJson())->AllTrade;

            $SCondition = "GroupIdKey = '$GroupIdKey' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWUserAccess)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                foreach ($AllTrade as $access) {

                    $expStr = explode(";", $access);
                    $arrStr[$expStr[0]][] = $expStr[1];

                }
                $jsonAllTrade = $objAclTools->JsonEncode($arrStr);

                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " AllTrade = '$jsonAllTrade' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate($UCondition, $USet, TableIWUserAccess);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}




