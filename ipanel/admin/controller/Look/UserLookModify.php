<?php
///controller/look/UserLookModify.php

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

$arrAcceptStat = array('عدم تایید', 'تایید');

if (@$objGlobalVar->RefFormGet()[0] != null) {

    $id = $objGlobalVar->RefFormGet()[0];
    $objEditView = $objORM->Fetch(" id = $id ", "*", TableIWUserLookDocuments);

    $objEditView->user_id = @$objORM->Fetch(
        "id = $objEditView->user_id",
        'Name',
        TableIWUser
    )->Name;

    //User Image
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

    $str_cart_front = $objShowFile->ShowImage('', $objShowFile->FileLocation("user_look"), $objEditView->id_cart_front, $objEditView->user_id, 750, '');
    $str_cart_back = $objShowFile->ShowImage('', $objShowFile->FileLocation("user_look"), $objEditView->id_cart_back, $objEditView->user_id, 750, '');
    $str_user_face = $objShowFile->ShowImage('', $objShowFile->FileLocation("user_look"), $objEditView->user_face, $objEditView->user_id, 750, '');


    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        $stat = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->stat);
        $admin_comment = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->admin_comment);

        $objTimeTools = new TimeTools();
        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $now_modify = date("Y-m-d H:i:s");
        $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

        $USet = " stat = $stat ,";
        $USet .= " admin_comment = '$admin_comment' ,";
        $USet .= " modify_ip = '$modify_ip' ,";
        $USet .= " last_modify = '$now_modify' ,";
        $USet .= " modify_id = $ModifyId ";
        $objORM->DataUpdate(" id = $id ", $USet, TableIWUserLookDocuments);

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
        exit();


    }

}