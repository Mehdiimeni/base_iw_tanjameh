<?php
//PartsModify.php
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";

$strChart = '';
foreach ($objORM->FetchAll($SCondition, 'PartName,IdKey', TableIWPanelAdminPart) as $ListItem) {
    $strChart .= '<li><div class="block">';
    $strChart .= '<div class="tags"><span><b>';
    $strChart .= $ListItem->PartName;
    $strChart .= '</b></span></div>';
    $strChart .= '<div class="block_content">';
    $SCondition = " Enabled = '$Enabled' AND PartIdKey = '$ListItem->IdKey'  ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'PageName', TableIWPanelAdminPage) as $ListItem2) {
        $strChart .= '<div class="tags"><span>';
        $strChart .=  $ListItem2->PageName ;
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
foreach ((new ACLTools())->TableNames() as $TableNameList)
{
    $strTableNames .= '<option>'.$TableNameList.'</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array( 'Description' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $PartName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PartName);
        $FaIcon = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->FaIcon);
        $TableName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TableName);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = BoolEnum::BOOL_TRUE();
        $SCondition = "Name = '$Name' OR PartName = '$PartName'  ";

        if ($objORM->DataExist($SCondition, TableIWPanelAdminPart)) {
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
            $InSet .= " PartName = '$PartName' ,";
            $InSet .= " FaIcon = '$FaIcon' ,";
            $InSet .= " TableName = '$TableName' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $InSet .= " ModifyId = '$ModifyId' ";

            $objORM->DataAdd($InSet, TableIWPanelAdminPart);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if(@$objGlobalVar->RefFormGet()[0] != null)
{
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,PartName,FaIcon,Description,TableName', TableIWPanelAdminPart);

    //table name
    $strTableNames = '<option selected>'.$objEditView->TableName.'</option>';
    foreach ((new ACLTools())->RmTableNames($objEditView->TableName) as $TableNameList)
    {
        $strTableNames .= '<option>'.$TableNameList.'</option>';
    }

    if (isset($_POST['SubmitM']) ) {
        $objAclTools = new ACLTools();

        $arrExcept = array( 'Description' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $PartName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PartName);
            $FaIcon = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->FaIcon);
            $TableName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TableName);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( Name = '$Name' OR PartName = '$PartName' ) and IdKey != '$IdKey'  ";

            if ($objORM->DataExist($SCondition, TableIWPanelAdminPart)) {
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
                $USet .= " PartName = '$PartName' ,";
                $USet .= " FaIcon = '$FaIcon' ,";
                $USet .= " TableName = '$TableName' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
                $USet .= " ModifyId = '$ModifyId' ";

                $objORM->DataUpdate($UCondition,$USet, TableIWPanelAdminPart);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify','ref')));
                exit();

            }


        }

    }
}

