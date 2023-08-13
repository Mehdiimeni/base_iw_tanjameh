<?php
//PagesModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;

$SCondition = " Enabled = $Enabled ORDER BY id ";

$strChart = '';
foreach ($objORM->FetchAll($SCondition, 'PartName,id', TableIWPanelAdminPart) as $ListItem) {
    $strChart .= '<li><div class="block">';
    $strChart .= '<div class="tags"><span><b>';
    $strChart .= $ListItem->PartName;
    $strChart .= '</b></span></div>';
    $strChart .= '<div class="block_content">';
    $SCondition = " Enabled = $Enabled AND iw_panel_admin_part_id = $ListItem->id  ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'PageName', TableIWPanelAdminPage) as $ListItem2) {
        $strChart .= '<div class="tags"><span>';
        $strChart .= $ListItem2->PageName;
        $strChart .= '</span></div>';

    }
    $strChart .= '</div>';
    $strChart .= '</div></li>';

}

$strChart = str_replace('<div class="block_content"></div>', '', $strChart);

switch ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->modify) {
    case 'add':
        $strModifyTitle = FA_LC["add"];
        break;
    case 'edit':
        $strModifyTitle = FA_LC["edit"];
        break;
    case 'view':
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
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'PartName,id', TableIWPanelAdminPart) as $ListItem) {
    $strPartIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->PartName . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('TopModify' => '', 'Description' => '');
    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $TopModify = @$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TopModify);
        if ($TopModify == null)
            $TopModify = 0;
        $PageName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PageName);
        $iw_panel_admin_part_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_panel_admin_part_id);
        $TableName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TableName);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = true;
        $SCondition = " ( Name = '$Name' OR PageName = '$PageName' ) and iw_panel_admin_part_id = '$iw_panel_admin_part_id' ";

        if ($objORM->DataExist($SCondition, TableIWPanelAdminPage)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = " Enabled = $Enabled ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " PageName = '$PageName' ,";
            $InSet .= " iw_panel_admin_part_id = '$iw_panel_admin_part_id' ,";
            $InSet .= " TableName = '$TableName' ,";
            $InSet .= " TopModify = '$TopModify' ";

            $objORM->DataAdd($InSet, TableIWPanelAdminPage);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,PageName,iw_panel_admin_part_id,Description,TableName,TopModify', TableIWPanelAdminPage);

    //table name
    $strTableNames = '<option selected>' . $objEditView->TableName . '</option>';
    foreach ((new ACLTools())->RmTableNames($objEditView->TableName) as $TableNameList) {
        $strTableNames .= '<option>' . $TableNameList . '</option>';
    }

    //Part Name
    $SCondition = "  id = $objEditView->iw_panel_admin_part_id ";
    $Item = $objORM->Fetch($SCondition, 'PartName,id', TableIWPanelAdminPart);
    $strPartIdKey = '<option selected value="' . $Item->id . '">' . $Item->PartName . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'PartName,id', TableIWPanelAdminPart) as $ListItem) {
        $strPartIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->PartName . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('TopModify' => '', 'Description' => '');
        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $TopModify = @$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TopModify);
            if ($TopModify == null)
                $TopModify = 0;
            $PageName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->PageName);
            $iw_panel_admin_part_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_panel_admin_part_id);
            $TableName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TableName);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( Name = '$Name' OR PageName = '$PageName' ) and iw_panel_admin_part_id = '$iw_panel_admin_part_id' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWPanelAdminPage)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " Name = '$Name' ,";
                $USet .= " PageName = '$PageName' ,";
                $USet .= " iw_panel_admin_part_id = '$iw_panel_admin_part_id' ,";
                $USet .= " TableName = '$TableName' ,";
                $USet .= " TopModify = '$TopModify' ";

                $objORM->DataUpdate($UCondition, $USet, TableIWPanelAdminPage);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}