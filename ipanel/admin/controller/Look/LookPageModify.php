<?php
///controller/Look/LookPageModify.php


require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;


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

//User No Image
$strUserImage = '';

//User Look Name
$strUserIdKey = '';
$SCondition = " 1  ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', ViewIWUserLook) as $ListItem) {
    $strUserIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageLookPageImage->name != null) {
            $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
            $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);



            $FileExt = $objStorageTools->FindFileExt('', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageLookPageImage->tmp_name);
            if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                exit();
            }
            if (!$objStorageTools->FileAllowSize('lookprofile', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageLookPageImage->tmp_name)) {

                JavaTools::JsAlertWithRefresh(FA_LC['enter_size_file_error'], 0, '');
                exit();
            }

            $FileNewName = $objStorageTools->FileSetNewName($FileExt);

        }


        $UserId = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->UserId);
        $LookPageName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LookPageName);
        $LookTitle = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LookTitle);

        $Enabled = true;
        $SCondition = "  LookPageName = '$LookPageName' and iw_user_IdRow = '$UserId' ";

        if ($objORM->DataExist($SCondition, TableIWUserLook)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            

            

            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = "";
            
            $InSet .= " Enabled = $Enabled ,";
            $InSet .= " LookTitle = '$LookTitle' ,";
            $InSet .= " LookPageName = '$LookPageName' ,";
            $InSet .= " LookPageImage = '$FileNewName' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWUserLook);
            if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageImage->name != null) {
                $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
                $objStorageTools->ImageOptAndStorage($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageImage->tmp_name, 'lookprofile', $FileNewName);
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
    $objEditView = $objORM->Fetch($SCondition, '*', ViewIWUserLook);


    //User Image
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

    $strLookPageImage = $objShowFile->ShowImage('', $objShowFile->FileLocation("lookprofile"), $objEditView->LookPageImage, $objEditView->LookPageName, 450, '');


    //User Look Name

    $SCondition = "  IdKey = '$objEditView->IdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', ViewIWUserLook);
    $strGroupIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', ViewIWUserLook) as $ListItem) {
        $strGroupIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $UserId = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->UserId);
            $LookPageName = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LookPageName);
            $LookTitle = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LookTitle);

            $SCondition = " LookPageName = '$LookPageName' and iw_user_IdRow = '$UserId' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWUserLook)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageImage->name != null) {
                    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
                    $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);

                    $FileExt = $objStorageTools->FindFileExt('', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageImage->tmp_name);
                    if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                        JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                        exit();
                    }
                    if (!$objStorageTools->FileAllowSize('lookprofile', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageImage->tmp_name)) {

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
                $USet .= "LookTitle = '$LookTitle' ,";
                $USet .= "LookPageName = '$LookPageName' ,";
                $USet .= "LookPageImage = '$FileNewName' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageImage->name != null) {
                    $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
                    $objStorageTools->ImageOptAndStorage($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->LookPageImage->tmp_name, 'lookprofile', $FileNewName);
                    $USet .= ", Image = '$FileNewName'";
                }

                $objORM->DataUpdate($UCondition, $USet, TableIWUserLook);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}