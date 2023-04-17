<?php
//UserTicketModify.php

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

if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $TicketSubject = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TicketSubject);
        $SenderTicket = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->SenderTicket);



        $objTimeTools = new TimeTools();
        $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $ModifyTime = $objTimeTools->jdate("H:i:s");
        $ModifyDate = $objTimeTools->jdate("Y/m/d");

        $IdKey = $objAclTools->IdKey();

        $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
        $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
        $InSet = "";
        $InSet .= " IdKey = '$IdKey' ,";
        $InSet .= " Enabled = '$Enabled' ,";
        $InSet .= " TicketSubject = '$TicketSubject' ,";
        $InSet .= " SenderTicket = '$SenderTicket' ,";
        $InSet .= " SenderIdKey = '$ModifyId' ,";
        $InSet .= " SetView = '0' ,";
        $InSet .= " SetPart = 'user' ,";
        $InSet .= " ModifyIP = '$ModifyIP' ,";
        $InSet .= " ModifyTime = '$ModifyTime' ,";
        $InSet .= " ModifyDate = '$ModifyDate' ,";
        $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
        $InSet .= " ModifyId = '$ModifyId' ";

        $objORM->DataAdd($InSet, TableIWTicket);

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
        exit();


    }

}

if (@$objGlobalVar->RefFormGet()[0] != null) {
    $IdKey = $objGlobalVar->RefFormGet()[0];
    $SCondition = "  IdKey = '$IdKey' ";
    $objEditView = $objORM->Fetch($SCondition, 'TicketSubject,SenderTicket,AnswerTicket', TableIWTicket);

    if (isset($_POST['SubmitM'])) {
        $objAclTools = new ACLTools();

        if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
            JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
            exit();
        } else {

            $AnswerTicket = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->AnswerTicket);


            $objTimeTools = new TimeTools();
            $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
            $ModifyTime = $objTimeTools->jdate("H:i:s");
            $ModifyDate = $objTimeTools->jdate("Y/m/d");
            $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
            $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

            $UCondition = " IdKey = '$IdKey' ";
            $USet = "";
            $USet .= " SetView = '1' ,";
            $USet .= " AnswerTicket = '$AnswerTicket' ,";
            $USet .= " ModifyIP = '$ModifyIP' ,";
            $USet .= " ModifyTime = '$ModifyTime' ,";
            $USet .= " ModifyDate = '$ModifyDate' ,";
            $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $USet .= " ModifyId = '$ModifyId' ";

            $objORM->DataUpdate($UCondition, $USet, TableIWTicket);

            $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
            JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify', 'ref')));
            exit();


        }

    }
}



