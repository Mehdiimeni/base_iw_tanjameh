<?php
//BannerModify.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;

//No Image
$strBannerImage = '';

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
$SCondition = " Enabled = $Enabled ORDER BY id ";
foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWWebGroupPart) as $ListItem) {
    $strGroupIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
}

//Position

$strPosition = '';
$strPosition .= '<option value="' . $objGlobalVar->FindArrayKey(PositionEnum::Positions['Right'], PositionEnum::Positions, 'l') . '">' . PositionEnum::Positions['Right'] . '</option>';
$strPosition .= '<option value="' . $objGlobalVar->FindArrayKey(PositionEnum::Positions['Left'], PositionEnum::Positions, 'l') . '">' . PositionEnum::Positions['Left'] . '</option>';
$strPosition .= '<option value="' . $objGlobalVar->FindArrayKey(PositionEnum::Positions['Center'], PositionEnum::Positions, 'l') . '">' . PositionEnum::Positions['Center'] . '</option>';


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    $arrExcept = array('BottomCaption' => '','SelectColor' => '', 'LinkTo' => '', 'Line1' => '', 'Line3' => '', 'Description' => '');

    if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
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
            if (!$objStorageTools->FileAllowSize('banner', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name)) {

                JavaTools::JsAlertWithRefresh(FA_LC['enter_size_file_error'], 0, '');
                exit();
            }

            $FileNewName = $objStorageTools->FileSetNewName($FileExt);

        }


        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $BottomCaption = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->BottomCaption);
        $LinkTo = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LinkTo);
        $Line1 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Line1);
        $Line2 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Line2);
        $Line3 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Line3);
        $SelectColor = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->SelectColor);

        $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
        $Position = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Position);
        $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


        $Enabled = true;
        $SCondition = "  Name = '$Name' AND GroupIdKey = '$GroupIdKey' ";

        if ($objORM->DataExist($SCondition, TableIWWebBanner)) {
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
            $InSet .= " Name = '$Name' ,";
            $InSet .= " Image = '$FileNewName' ,";
            $InSet .= " LinkTo = '$LinkTo' ,";
            $InSet .= " Position = '$Position' ,";
            $InSet .= " BottomCaption = '$BottomCaption' ,";
            $InSet .= " Line1 = '$Line1' ,";
            $InSet .= " Line2 = '$Line2' ,";
            $InSet .= " Line3 = '$Line3' ,";
            $InSet .= " SelectColor = '$SelectColor' ,";
            $InSet .= " Description = '$Description' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $ModifyId ";

            $objORM->DataAdd($InSet, TableIWWebBanner);
            if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {
                $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
                $objStorageTools->ImageOptAndStorage($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name, 'banner', $FileNewName);
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
    $objEditView = $objORM->Fetch($SCondition, '*', TableIWWebBanner);

    //image
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL.'img/');
    $strBannerImage = $objShowFile->ShowImage( '', $objShowFile->FileLocation( "banner" ), $objEditView->Image, $objEditView->Name, 450, '' );

    //Group Name
    $SCondition = "  IdKey = '$objEditView->GroupIdKey' ";
    $Item = $objORM->Fetch($SCondition, 'Name,id', TableIWWebGroupPart);
    $strGroupIdKey = '<option selected value="' . $Item->id . '">' . $Item->Name . '</option>';
    $SCondition = " Enabled = $Enabled ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'Name,id', TableIWWebGroupPart) as $ListItem) {
        $strGroupIdKey .= '<option value="' . $ListItem->id . '">' . $ListItem->Name . '</option>';
    }

    //Position


    $strPosition = '';
    $arrPostition = ['Right','Left','Center'];
    foreach ($arrPostition as $Postition)
    {
        $strSelected = '';
        if( $objEditView->Position == strtolower($Postition)  )
            $strSelected = 'selected';

        $strPosition .= '<option '.$strSelected.' value="' . $objGlobalVar->FindArrayKey(PositionEnum::Positions[$Postition], PositionEnum::Positions, 'l') . '">' . PositionEnum::Positions[$Postition] . '</option>';

    }



    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $arrExcept = array('BottomCaption' => '', 'SelectColor'=>'', 'LinkTo' => '', 'Line1' => '', 'Line3' => '', 'Description' => '');

        if ($objAclTools->CheckNullExcept($objAclTools->PostVarToJson(), $arrExcept)) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
            $BottomCaption = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->BottomCaption);
            $LinkTo = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->LinkTo);
            $Line1 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Line1);
            $Line2 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Line2);
            $Line3 = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Line3);
            $SelectColor = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->SelectColor);

            $GroupIdKey = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->GroupIdKey);
            $Position = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Position);
            $Description = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Description);


            $Enabled = true;
            $SCondition = "  Name = '$Name' AND GroupIdKey = '$GroupIdKey' and id!= $IdKey  ";

            if ($objORM->DataExist($SCondition, TableIWWebBanner)) {
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
                    if (!$objStorageTools->FileAllowSize('banner', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name)) {

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
                $USet .= " GroupIdKey = '$GroupIdKey' ,";
                $USet .= " Name = '$Name' ,";
                $USet .= " LinkTo = '$LinkTo' ,";
                $USet .= " Position = '$Position' ,";
                $USet .= " BottomCaption = '$BottomCaption' ,";
                $USet .= " Line1 = '$Line1' ,";
                $USet .= " Line2 = '$Line2' ,";
                $USet .= " Line3 = '$Line3' ,";
                $USet .= " SelectColor = '$SelectColor' ,";
                $USet .= " Description = '$Description' ,";
                $USet .= " modify_ip = '$modify_ip' ,";
                
                
                $USet .= " last_modify = '$now_modify' ,";
                $USet .= " modify_id = $ModifyId ";

                if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->name != null) {
                    $objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
                    $objStorageTools->ImageOptAndStorage($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->Image->tmp_name, 'banner', $FileNewName);
                    $USet .= ", Image = '$FileNewName'";
                }

                $objORM->DataUpdate($UCondition, $USet, TableIWWebBanner);

                $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
                JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
                exit();

            }


        }

    }
}




