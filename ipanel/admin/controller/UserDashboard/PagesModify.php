<?php
//PagesModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;

$SCondition = " Enabled = $Enabled ORDER BY id ";

$strChart = '';
foreach ($objORM->FetchAll($SCondition, 'PartName,id', TableIWPanelUserPart) as $ListItem) {
    $strChart .= '<li><div class="block">';
    $strChart .= '<div class="tags"><span>';
    $strChart .= $ListItem->PartName;
    $strChart .= '</span></div>';
    $strChart .= '<div class="block_content">';
    $SCondition = " Enabled = $Enabled AND iw_panel_user_part_id = $ListItem->id  ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'PageName', TableIWPanelUserPage) as $ListItem2) {
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
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'PartName,id', TableIWPanelUserPart) as $ListItem) {
    $strPartIdKey .= '<option value="'.$ListItem->id.'">' . $ListItem->PartName . '</option>';
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
        $iw_panel_user_part_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_panel_user_part_id);
        $TableName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TableName);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);
        $Enabled = true;
        $SCondition = " ( Name = '$Name' OR PageName = '$PageName' ) and iw_panel_user_part_id = '$iw_panel_user_part_id' ";

        if ($objORM->DataExist($SCondition, TableIWPanelUserPage)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));
            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " Name = '$Name' ,";
            $InSet .= " PageName = '$PageName' ,";
            $InSet .= " iw_panel_user_part_id = '$iw_panel_user_part_id' ,";
            $InSet .= " TableName = '$TableName' ,";
            $InSet .= " TopModify = '$TopModify' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWPanelUserPage);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,PageName,iw_panel_user_part_id,Description,TableName,TopModify', TableIWPanelUserPage);

    //table name
    $strTableNames = '<option selected>' . $objEditView->TableName . '</option>';
    foreach ((new ACLTools())->RmTableNames($objEditView->TableName) as $TableNameList) {
        $strTableNames .= '<option>' . $TableNameList . '</option>';
    }

    //Part Name
    $SCondition = "  IdKey = '$objEditView->iw_panel_user_part_id' ";
    $Item = $objORM->Fetch($SCondition, 'PartName,id', TableIWPanelUserPart);
    $strPartIdKey = '<option selected value="'.$Item->id.'">' . $Item->PartName . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'PartName,id', TableIWPanelUserPart) as $ListItem) {
        $strPartIdKey .= '<option value="'.$ListItem->id.'">' . $ListItem->PartName . '</option>';
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
            $iw_panel_user_part_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_panel_user_part_id);
            $TableName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TableName);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( Name = '$Name' OR PageName = '$PageName' ) and iw_panel_user_part_id = '$iw_panel_user_part_id' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWPanelUserPage)) {
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
                $USet .= " iw_panel_user_part_id = '$iw_panel_user_part_id' ,";
                $USet .= " TableName = '$TableName' ,";
                $USet .= " TopModify = '$TopModify' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                $objORM->DataUpdate($UCondition, $USet, TableIWPanelUserPage);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}


