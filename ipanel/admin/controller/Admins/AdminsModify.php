<?php
//AdminsModify.php

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

//User No Image
$strUserImage = '';

//table name
$strTableNames = '';
foreach ((new ACLTools())->TableNames() as $TableNameList) {
    $strTableNames .= '<option>' . $TableNameList . '</option>';
}

//Group Name
$striw_admin_group_id = '';
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWAdminGroup) as $ListItem) {
    $striw_admin_group_id .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) 
        {
            $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
            $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);


            
            $FileExt = $objStorageTools->FindFileExt('', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name);
            if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                exit();
            }
            if (!$objStorageTools->FileAllowSize('adminprofile', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name)) {

                JavaTools::JsAlertWithRefresh(FA_LC['enter_size_file_error'], 0, '');
                exit();
            }

            $FileNewName = $objStorageTools->FileSetNewName($FileExt);

        }


        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
        $CellNumber = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CellNumber);
        $iw_admin_group_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_admin_group_id);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

        $UsernameL = $objAclTools->en2Base64($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Username, 1);
        $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);

        $Enabled = true;
        $SCondition = " (  Username = '$UsernameL' ) and iw_admin_group_id = $iw_admin_group_id ";

        if ($objORM->DataExist($SCondition, TableIWAdmin)) {
            JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
            exit();

        } else {

            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

            $InSet = " Enabled = $Enabled ,";
            $InSet .= " UserName = '$UsernameL' ,";
            $InSet .= " Password = '$PasswordL' ,";
            $InSet .= " iw_admin_group_id = $iw_admin_group_id ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWAdmin);
            if ( $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null ) {
                $objStorageTools->SetRootStoryFile('../irepository/img/');
                $objStorageTools->FileCopyServer( $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name, 'adminprofile', $FileNewName );
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
    $objEditView = $objORM->Fetch($SCondition, 'iw_admin_group_id,Username', TableIWAdmin);
    //Show decode username
    $objEditView->Username = $objGlobalVar->de2Base64($objEditView->Username);

//User Image
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL.'img/');

    $strUserImage =    $objShowFile->ShowImage( '', $objShowFile->FileLocation( "adminprofile" ), $objEditView->Image, $objEditView->Name, 450, '' );


    //Group Name
    $SCondition = "  id = $objEditView->iw_admin_group_id ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWAdminGroup);
    $striw_admin_group_id = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWAdminGroup) as $ListItem) {
        $striw_admin_group_id .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $Email = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Email);
            $CellNumber = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->CellNumber);
            $iw_admin_group_id = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->iw_admin_group_id);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);

            $UsernameL = $objAclTools->en2Base64($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Username, 1);
            $PasswordL = $objAclTools->mdShal($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Password, 0);

            $SCondition = "(Username = '$UsernameL'  ) and iw_admin_group_id = $iw_admin_group_id and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWAdmin)) {
                JavaTools::JsAlertWithRefresh(FA_LC['enter_data_exist'], 0, '');
                exit();

            } else {

                if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null)
                {
                    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
                    $objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);

                    $FileExt = $objStorageTools->FindFileExt('', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name);
                    if (!$objStorageTools->FileAllowFormat(FileSizeEnum::ExtImage(), $FileExt)) {

                        JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                        exit();
                    }
                    if (!$objStorageTools->FileAllowSize('adminprofile', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name)) {

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
                $USet .= " UserName = '$UsernameL' ,";
                $USet .= " Password = '$PasswordL' ,";
                $USet .= " iw_admin_group_id = $iw_admin_group_id ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                if ( $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null ) {
                    $objStorageTools->SetRootStoryFile('../irepository/img/');
                    $objStorageTools->FileCopyServer( $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name, 'adminprofile', $FileNewName );
                    $USet .= ", Image = '$FileNewName'";
                }

                $objORM->DataUpdate($UCondition, $USet, TableIWAdmin);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}



