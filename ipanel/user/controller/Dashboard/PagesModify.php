<?php
//PagesModify.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";

$strChart = '';
foreach ($objORM->FetchAll($SCondition, 'PartName,IdKey', TableIWPanelAdminPart) as $ListItem) {
    $strChart .= '<li><div class="block">';
    $strChart .= '<div class="tags"><span>';
    $strChart .= $ListItem->PartName;
    $strChart .= '</span></div>';
    $strChart .= '<div class="block_content">';
    $SCondition = " Enabled = '$Enabled' AND PartIdKey = '$ListItem->IdKey'  ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'PageName', TableIWPanelAdminPage) as $ListItem2) {
        $strChart .= '<div class="tags"><span>';
        $strChart .= '<p class="title">' . $ListItem2->PageName . '</p>';
        $strChart .= '</span></div>';

    }
    $strChart .= '</div>';
    $strChart .= '</div></li>';

}

$strChart = str_replace('<div class="block_content"></div>', '', $strChart);

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
//table name
$strTableNames = '';
foreach ((new ACLTools())->TableNames() as $TableNameList) {
    $strTableNames .= '<option>' . $TableNameList . '</option>';
}

//Part Name
$strPartIdKey = '';
$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'PartName,IdKey', TableIWPanelAdminPart) as $ListItem) {
    $strPartIdKey .= '<option value="'.$ListItem->IdKey.'">' . $ListItem->PartName . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $TopModify = @$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TopModify);
        if($TopModify == null)
            $TopModify = 0;
        $PageName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PageName);
        $PartIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PartIdKey);
        $TableName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TableName);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = " ( Name = '$Name' OR PageName = '$PageName' ) and PartIdKey = '$PartIdKey' ";

        if ($objORM->DataExist($SCondition, TableIWPanelAdminPage)) {
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
            $InSet .= " Name = '$Name' ,";
            $InSet .= " PageName = '$PageName' ,";
            $InSet .= " PartIdKey = '$PartIdKey' ,";
            $InSet .= " TableName = '$TableName' ,";
            $InSet .= " TopModify = '$TopModify' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWPanelAdminPage);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,PageName,PartIdKey,Description,TableName,TopModify', TableIWPanelAdminPage);

    //table name
    $strTableNames = '<option selected>' . $objEditView->TableName . '</option>';
    foreach ((new ACLTools())->RmTableNames($objEditView->TableName) as $TableNameList) {
        $strTableNames .= '<option>' . $TableNameList . '</option>';
    }

    //Part Name
    $SCondition = "  IdKey = '$objEditView->PartIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'PartName,IdKey', TableIWPanelAdminPart);
    $strPartIdKey = '<option selected value="'.$Item->IdKey.'">' . $Item->PartName . '</option>';
    $SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'PartName,IdKey', TableIWPanelAdminPart) as $ListItem) {
        $strPartIdKey .= '<option value="'.$ListItem->IdKey.'">' . $ListItem->PartName . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $TopModify = @$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TopModify);
            if($TopModify == null)
                $TopModify = 0;
            $PageName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PageName);
            $PartIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PartIdKey);
            $TableName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TableName);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( Name = '$Name' OR PageName = '$PageName' ) and PartIdKey = '$PartIdKey' and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWPanelAdminPage)) {
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
                $USet .= " Name = '$Name' ,";
                $USet .= " PageName = '$PageName' ,";
                $USet .= " PartIdKey = '$PartIdKey' ,";
                $USet .= " TableName = '$TableName' ,";
                $USet .= " TopModify = '$TopModify' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWPanelAdminPage);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}


