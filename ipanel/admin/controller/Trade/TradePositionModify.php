<?php
//TradePositionModify.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
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
$strGroupIdKey = '<option value="">' . FA_LC["select"] . '</option>';
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWTradeGroup) as $ListItem) {
    $strGroupIdKey .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
}

// Trade Name
$strTradeIdKey = '<option value="">' . FA_LC["select"] . '</option>';

// Type
$strTypePosition = '';
$arrTypePosition = array('Buy', 'Sale');
foreach ($arrTypePosition as $ListItem) {
    $strTypePosition .= '<option value="' . $ListItem . '">' . $ListItem . '</option>';
}
// Time
$strTimePosition = '';
$arrTimePosition = array('Long', 'Mid', 'Short');
foreach ($arrTimePosition as $ListItem) {
    $strTimePosition .= '<option value="' . $ListItem . '">' . $ListItem . '</option>';
}


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $TradeIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TradeIdKey);
        $TypePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TypePosition);
        $TimePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TimePosition);
        $OpenPosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->OpenPosition);
        $ClosePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ClosePosition);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "  GroupIdKey = '$GroupIdKey' OR TradeIdKey = '$TradeIdKey'  ";

        if ($objORM->DataExist($SCondition, TableIWTradePosition)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");

            $IdKey = $objAclTools->IdKey();

            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

            $InSet = "";
            $InSet .= " IdKey = '$IdKey' ,";
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " TradeIdKey = '$TradeIdKey' ,";
            $InSet .= " TypePosition = '$TypePosition' ,";
            $InSet .= " TimePosition = '$TimePosition' ,";
            $InSet .= " OpenPosition = '$OpenPosition' ,";
            $InSet .= " ClosePosition = '$ClosePosition' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWTradePosition);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'GroupIdKey,TradeIdKey,TypePosition,TimePosition,OpenPosition,ClosePosition,Description', TableIWTradePosition);


    //Group Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,IdKey', TableIWTradeGroup);
    $strGroupIdKey = '<option selected value="' . $Item->IdKey . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWTradeGroup) as $ListItem) {
        $strGroupIdKey .= '<option value="' . $ListItem->IdKey . '">' . $ListItem->Name . '</option>';
    }

    // Trade Name
    $SCondition = "  IdKey = '$objEditView->TradeIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,IdKey', TableIWTrade);
    $strTradeIdKey = '<option selected value="' . $Item->IdKey . '">' . $Item->Name . '</option>';

    // Type
    $strTypePosition = '<option value="' . $objEditView->TypePosition . '">' . $objEditView->TypePosition . '</option>';
    $arrTypePosition = array('Buy', 'Sale');
    $arrTypePosition = array_diff($arrTypePosition, array($objEditView->TypePosition));
    foreach ($arrTypePosition as $ListItem) {
        $strTypePosition .= '<option value="' . $ListItem . '">' . $ListItem . '</option>';
    }
// Time
    $strTimePosition = '<option value="' . $objEditView->TimePosition . '">' . $objEditView->TimePosition . '</option>';
    $arrTimePosition = array('Long', 'Mid', 'Short');
    $arrTimePosition = array_diff($arrTimePosition, array($objEditView->TimePosition));
    foreach ($arrTimePosition as $ListItem) {
        $strTimePosition .= '<option value="' . $ListItem . '">' . $ListItem . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
            $TradeIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TradeIdKey);
            $TypePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TypePosition);
            $TimePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TimePosition);
            $OpenPosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->OpenPosition);
            $ClosePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ClosePosition);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( GroupIdKey = '$GroupIdKey' OR TradeIdKey = '$TradeIdKey' )  and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWTradePosition)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {


                $objTimeTools = new TimeTools();
                $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $ModifyTime = $objTimeTools->jdate("H:i:s");
                $ModifyDate = $objTimeTools->jdate("Y/m/d");
                $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

                $UCondition = " IdKey = '$IdKey' ";
                $USet = "";
                $USet .= " GroupIdKey = '$GroupIdKey' ,";
                $USet .= " TradeIdKey = '$TradeIdKey' ,";
                $USet .= " TypePosition = '$TypePosition' ,";
                $USet .= " TimePosition = '$TimePosition' ,";
                $USet .= " OpenPosition = '$OpenPosition' ,";
                $USet .= " ClosePosition = '$ClosePosition' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";


                $objORM->DataUpdate($UCondition, $USet, TableIWTradePosition);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}





