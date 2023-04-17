<?php
//CreditModify3.php

$apiMainName = 'Transaction';

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

//Card Holders Name
$strAmount = '';

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

foreach (array(25000,26000,27000,28000,29000,30000) as $ListItem) {
    $strAmount .= '<option value="' . $ListItem . '">' . $ListItem . '</option>';

}


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $Amount = (int)$objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Amount)*10000;
/*
        $Token = (string)rand(1000000,2000000);
        $Status = 1;
        $OrderId = rand(1000000,2000000);
        $TerminalNo = 44825519;
        $RRN = rand(1000000000,2000000000);
        $objTimeTools = new TimeTools();
        $ModifyStrTime = "2021-11-16T00:00:00+03:30";

        $arrPost = array('Customer_Id' => 1, 'Amount'=>$Amount, 'Token' => $Token, 'Status' => $Status,'OrderId'=>$OrderId,'TerminalNumber'=>$TerminalNo,'RRN'=>$RRN);
        $JsonPostData = $objAclTools->JsonEncode($arrPost);

        $objKMN->Post($JsonPostData);

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
        exit();
*/

        ini_set ( "soap.wsdl_cache_enabled", "0" );


        $PIN = 'o3bS4IIGtY7bvwFLv4O0';
        $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL";
        $site_call_back_url = "https://tanjameh.com/ipanel/user.php?ln=&backset=t";

        $amount = $Amount ;
        $order_id = rand(1,140000);

        $params = array (
            "LoginAccount" => $PIN,
            "Amount" => $amount,
            "OrderId" => $order_id,
            "CallBackUrl" => $site_call_back_url
        );


        $client = new SoapClient ( $wsdl_url );

        try {
            $result = $client->SalePaymentRequest ( array (
                "requestData" => $params
            ) );

            if ($result->SalePaymentRequestResult->Token && $result->SalePaymentRequestResult->Status === 0) {

                JavaTools::JsTimeRefresh(0, "https://pec.shaparak.ir/NewIPG/?Token=" . $result->SalePaymentRequestResult->Token );
                exit ();
            }
            elseif ( $result->SalePaymentRequestResult->Status  != '0') {
                $err_msg = "(<strong> کد خطا : " . $result->SalePaymentRequestResult->Status . "</strong>) " .
                    $result->SalePaymentRequestResult->Message ;
            }
        } catch ( Exception $ex ) {
            $err_msg =  $ex->getMessage()  ;
        }


    }

}







