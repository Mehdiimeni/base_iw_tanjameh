<?php
//TradePositionModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";
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

$arrUserTradeIdKey = array();
foreach ($arrAllTrade as $AllTrade)
{
    foreach ($AllTrade as  $Trade)
    {
        $arrUserTradeIdKey[] = "'".$Trade."'";
    }

}
$impUserTradeIdKey = implode(",",$arrUserTradeIdKey);

$strListBody = '';
count($arrUserTradeIdKey) > 1 ? $SCondition = " Enabled = $Enabled and IdKey IN ($impUserTradeIdKey)" : $SCondition = " Enabled = $Enabled and IdKey = '$impUserTradeIdKey'";

//Group Name
$strTradeIdKey = '<option value="">' . FA_LC["select"] . '</option>';
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWTrade) as $ListItem) {
    $strTradeIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}



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

        $TradeIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TradeIdKey);

        $SCondition = " IdKey = '$TradeIdKey' ";
        $GroupIdKey = $objORM->Fetch($SCondition, 'GroupIdKey', TableIWTrade)->GroupIdKey;

        $TypePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TypePosition);
        $TimePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TimePosition);
        $OpenPosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->OpenPosition);
        $ClosePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ClosePosition);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = true;
        $SCondition = "  GroupIdKey = '$GroupIdKey' OR TradeIdKey = '$TradeIdKey'  ";

        if ($objORM->DataExist($SCondition, TableIWTradePosition)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " TradeIdKey = '$TradeIdKey' ,";
            $InSet .= " TypePosition = '$TypePosition' ,";
            $InSet .= " TimePosition = '$TimePosition' ,";
            $InSet .= " OpenPosition = '$OpenPosition' ,";
            $InSet .= " ClosePosition = '$ClosePosition' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWTradePosition);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'TradeIdKey,TypePosition,TimePosition,OpenPosition,ClosePosition,Description', TableIWTradePosition);


    // Trade Name
    $SCondition = "  IdKey = '$objEditView->TradeIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWTrade);
    $strTradeIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';

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


            $TradeIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TradeIdKey);
            $SCondition = " IdKey = '$TradeIdKey' ";
            $GroupIdKey = $objORM->Fetch($SCondition, 'GroupIdKey', TableIWTrade)->GroupIdKey;
            $TypePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TypePosition);
            $TimePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TimePosition);
            $OpenPosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->OpenPosition);
            $ClosePosition = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->ClosePosition);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( GroupIdKey = '$GroupIdKey' OR TradeIdKey = '$TradeIdKey' )  and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWTradePosition)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {


                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " GroupIdKey = '$GroupIdKey' ,";
                $USet .= " TradeIdKey = '$TradeIdKey' ,";
                $USet .= " TypePosition = '$TypePosition' ,";
                $USet .= " TimePosition = '$TimePosition' ,";
                $USet .= " OpenPosition = '$OpenPosition' ,";
                $USet .= " ClosePosition = '$ClosePosition' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";


                $objORM->DataUpdate($UCondition, $USet, TableIWTradePosition);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}






