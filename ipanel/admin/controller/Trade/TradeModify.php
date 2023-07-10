<?php
//TradeModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
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
//table name
$strTableNames = '';
foreach ((new ACLTools())->TableNames() as $TableNameList) {
    $strTableNames .= '<option>' . $TableNameList . '</option>';
}

//Group Name
$strGroupIdKey = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWTradeGroup) as $ListItem) {
    $strGroupIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {
            $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
            $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);

            $FileExt = $objStorageTools->FindFileExt('', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name);
            if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                exit();
            }
            if (!$objStorageTools->FileAllowSize('logo', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name)) {

                JavaTools::JsAlertWithRefresh(FA_LC['enter_size_file_error'], 0, '');
                exit();
            }

            $FileNewName = $objStorageTools->FileSetNewName($FileExt);

        }


        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $TradeName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TradeName);
        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = true;
        $SCondition = " ( Name = '$Name' OR TradeName = '$TradeName' ) and GroupIdKey = '$GroupIdKey' ";

        if ($objORM->DataExist($SCondition, TableIWTrade)) {
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
            $InSet .= " TradeName = '$TradeName' ,";
            $InSet .= " Image = '$FileNewName' ,";
            $InSet .= " GroupIdKey = '$GroupIdKey' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWTrade);
            if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {
                $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
                $objStorageTools->ImageOptAndStorage($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name, 'logo', $FileNewName);
            }

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
            exit();

        }


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'Name,GroupIdKey,Description,TradeName,Image', TableIWTrade);


    //Group Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWTradeGroup);
    $strGroupIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWTradeGroup) as $ListItem) {
        $strGroupIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $TradeName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TradeName);
            $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $SCondition = "( Name = '$Name' OR TradeName = '$TradeName' ) and GroupIdKey = '$GroupIdKey' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWTrade)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {
                    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
                    $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);

                    $FileExt = $objStorageTools->FindFileExt('', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name);
                    if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                        JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                        exit();
                    }
                    if (!$objStorageTools->FileAllowSize('logo', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name)) {

                        JavaTools::JsAlertWithRefresh(FA_LC['enter_size_file_error'], 0, '');
                        exit();
                    }

                    $FileNewName = $objStorageTools->FileSetNewName($FileExt);

                }

                $objTimeTools = new TimeTools();
                $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
                
                
                $now_modify = date("Y-m-d H:i:s");
                $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

                $UCondition = " id = $IdKey ";
                $USet = "";
                $USet .= " Name = '$Name' ,";
                $USet .= " TradeName = '$TradeName' ,";
                $USet .= " GroupIdKey = '$GroupIdKey' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";


                if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {

                    $USet .= " ,Image = '$FileNewName' ";
                    $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
                    $objStorageTools->ImageOptAndStorage($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name, 'logo', $FileNewName);
                }

                $objORM->DataUpdate($UCondition, $USet, TableIWTrade);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}




