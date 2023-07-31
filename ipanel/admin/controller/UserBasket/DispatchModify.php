<?php
//DispatchModify.php

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

$strCopFile = '';

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $packing_number = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  packing_number = '$packing_number' ";
    $fileCopFile = $objORM->Fetch($SCondition, 'cop_file', TableIWShippingProduct)->cop_file;


    //CopFile

    if ($fileCopFile != '')
        $strCopFile = '<a target="_blank" href="' . IW_REPOSITORY_FROM_PANEL . 'attach/copfile/download/' . $fileCopFile . '">COP File Click</a>';


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
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();


            $now_modify = date("Y-m-d H:i:s");


            if ($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->CopFile->name != null) {
                $objFileToolsInit->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'attach/copfile/');
                $objFileToolsInit->FileCopyServer($objAclTools->JsonDecode($objGlobalVar->FileVarToJson())->CopFile->tmp_name, 'download', $FileNewName);
                $USet = " cop_file = '$FileNewName'";
            }

            $objORM->DataUpdate(" packing_number = '$packing_number' ", $USet, TableIWShippingProduct);


            $booking_status_id = $objORM->Fetch("status = 'dispatch'", "id", TableIWUserOrderStatus)->id;

            foreach ($objORM->FetchAll(" packing_number = $packing_number ", "invoice_id", TableIWShippingProduct) as $ListItem) {
                $objORM->DataUpdate(
                    "id = $ListItem->invoice_id ",
                    "user_order_status_id = $booking_status_id  ",
                    TableIWAUserInvoice
                );
            }

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
            exit();

        }


    }

}