<?php
//UserTradeModify.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
$Enabled = BoolEnum::BOOL_TRUE();

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
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWUserGroup) as $ListItem) {
    $strGroupIdKey .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
}
//All Trade
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";

$strAllTrade = '';
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWTradeGroup) as $ListItem) {
    $strAllTrade .= '<optgroup  label=' . $ListItem->Name . '>';

    $SCondition = " Enabled = '$Enabled' AND GroupIdKey = '$ListItem->IdKey'  ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWTrade) as $ListItem2) {
        $strAllTrade .= '<option value=' . $ListItem->IdKey . ';' . $ListItem2->IdKey . '>';
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

        $Enabled = BoolEnum::BOOL_TRUE();
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
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");

            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
            $UCondition = " GroupIdKey = '$GroupIdKey' ";
            $USet = "";
            $USet .= " AllTrade = '$jsonAllTrade' ,";
            $USet .= " ModifyIP = '$ModifyIP' ,";
            $USet .= " ModifyTime = '$ModifyTime' ,";
            $USet .= " ModifyDate = '$ModifyDate' ,";
            $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $USet .= " ModifyId = '$ModifyId' ";

            $objORM->DataUpdate($UCondition, $USet, TableIWUserAccess);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'AllTrade,GroupIdKey', TableIWUserAccess);

    //Part Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,IdKey', TableIWUserGroup);
    $strGroupIdKey = '<option selected value="' . $Item->IdKey . '">' . $Item->Name . '</option>';


    //All Trade
    $SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
    $arrExitViewTrade = ($objGlobalVar->JsonDecodeArray($objEditView->AllTrade));
    $strAllTrade = '';
    foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWTradeGroup) as $ListItem) {
        $strAllTrade .= '<optgroup  label=' . $ListItem->Name . '>';

        $SCondition = " Enabled = '$Enabled' AND GroupIdKey = '$ListItem->IdKey'  ORDER BY IdRow ";
        foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWTrade) as $ListItem2) {
            $selected = '';
            if (isset($arrExitViewTrade[$ListItem->IdKey]))
                if (array_search($ListItem2->IdKey, $arrExitViewTrade[$ListItem->IdKey]) > -1)
                    $selected = 'selected';

            $strAllTrade .= '<option value=' . $ListItem->IdKey . ';' . $ListItem2->IdKey . ' ' . $selected . ' >';
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

            $SCondition = "GroupIdKey = '$GroupIdKey' and IdKey != '$IdKey'  ";

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
                $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $ModifyTime = $objTimeTools->jdate("H:i:s");
                $ModifyDate = $objTimeTools->jdate("Y/m/d");
                $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " AllTrade = '$jsonAllTrade' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWUserAccess);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}




