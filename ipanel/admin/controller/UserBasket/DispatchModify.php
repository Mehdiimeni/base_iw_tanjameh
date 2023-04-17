<?php
//DispatchModify.php

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

$strCopFile = '';

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $PackingNu = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  PackingNu = '$PackingNu' ";
    $fileCopFile = $objORM->Fetch($SCondition, 'CopFile', TableIWAUserMainCart)->CopFile;


//CopFile

    if ($fileCopFile != '')
        $strCopFile = '<a target="_blank" href="' . IW_REPOSITORY_FROM_PANEL . 'attach/copfile/download/' . $fileCopFile . '">Cop File Click</a>';


    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {


            if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->CopFile->name != null) {
                $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
                $FileExt = $objFileToolsInit->FindFileExt($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->CopFile->tmp_name, $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->CopFile->name);

                if (!$objFileToolsInit->FileAllowFormat(FileSizeEnum::ExtAttached(), $FileExt)) {

                    JavaTools::JsAlertWithRefresh(FA_LC['enter_format_file_error'], 0, '');
                    exit();
                }
                if (!$objFileToolsInit->FileAllowSize('download', $objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->CopFile->tmp_name)) {

                    JavaTools::JsAlertWithRefresh(FA_LC['enter_size_file_error'], 0, '');
                    exit();
                }

                $FileNewName = $objFileToolsInit->FileSetNewName($FileExt, 1, 0);

            }

            $objTimeTools = new TimeTools();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");
            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;

            $UCondition = " PackingNu = '$PackingNu' ";
            $USet = "";
            $USet .= " ChkState = 'dispatch' ,";

            $USet .= " ModifyIP = '$ModifyIP' ,";
            $USet .= " ModifyTime = '$ModifyTime' ,";
            $USet .= " ModifyDate = '$ModifyDate' ,";
            $USet .= " ModifyStrTime = '$ModifyStrTime'";

            if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->CopFile->name != null) {
                $objFileToolsInit->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'attach/copfile/');
                $objFileToolsInit->FileCopyServer($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->CopFile->tmp_name, 'download', $FileNewName);
                $USet .= ", CopFile = '$FileNewName'";
            }

            $objORM->DataUpdate($UCondition, $USet, TableIWAUserMainCart);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
            exit();

        }


    }

}




