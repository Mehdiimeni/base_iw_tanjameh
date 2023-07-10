<?php
//UserTicketModify.php

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

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $TicketSubject = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TicketSubject);
        $SenderTicket = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->SenderTicket);



        $objTimeTools = new TimeTools();
        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        
        

        

        $now_modify = date("Y-m-d H:i:s");
        $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
        $InSet = "";
        
        $InSet .= " Enabled = $Enabled ,";
        $InSet .= " TicketSubject = '$TicketSubject' ,";
        $InSet .= " SenderTicket = '$SenderTicket' ,";
        $InSet .= " SenderIdKey = '$ModifyId' ,";
        $InSet .= " SetView = '0' ,";
        $InSet .= " SetPart = 'user' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        
        
        $InSet .= " last_modify = '$now_modify' ,";
        $InSet .= " modify_id = $ModifyId ";

        $objORM->DataAdd($InSet, TableIWTicket);

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
        exit();


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  id = $IdKey ";
    $objEditView = $objORM->Fetch($SCondition, 'TicketSubject,SenderTicket,AnswerTicket', TableIWTicket);

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $AnswerTicket = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->AnswerTicket);


            $objTimeTools = new TimeTools();
            $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            
            
            $now_modify = date("Y-m-d H:i:s");
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));

            $UCondition = " id = $IdKey ";
            $USet = "";
            $USet .= " SetView = '1' ,";
            $USet .= " AnswerTicket = '$AnswerTicket' ,";
            $USet .= " modify_ip = '$modify_ip' ,";
            
            
            $USet .= " last_modify = '$now_modify' ,";
            $USet .= " modify_id = $ModifyId ";

            $objORM->DataUpdate($UCondition, $USet, TableIWTicket);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
            exit();


        }

    }
}



