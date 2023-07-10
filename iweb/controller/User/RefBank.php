<?php
//RefBank.php


if (!isset($_POST['Status'])) {
    JavaTools::JsAlertWithRefresh(FA_LC['bank_do_not_response'], 0, './?part=User&page=Checkout');
    exit();
} else {

    if ($_POST['Status'] == 1) {
        JavaTools::JsAlertWithRefresh(FA_LC['canceled_by_user__1'], 0, './?part=User&page=Checkout');
        exit();
    }

    if ($_POST['Status'] == 3) {
        JavaTools::JsAlertWithRefresh(FA_LC['payment_not_ok__3'], 0, './?part=User&page=Checkout');
        exit();
    }
    if ($_POST['Status'] == 4) {
        JavaTools::JsAlertWithRefresh(FA_LC['payment_not_send__4'], 0, './?part=User&page=Checkout');
        exit();
    }
    if ($_POST['Status'] == 5) {
        JavaTools::JsAlertWithRefresh(FA_LC['invalid_parameters__5'], 0, './?part=User&page=Checkout');
        exit();
    }
}

if ($_POST['Status'] == 2) {

    require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
    $objGlobalVar = new GlobalVarTools();

    $Enabled = true;

    $objTimeTools = new TimeTools();
    $objAclTools = new ACLTools();

    $ResitId = $_POST['ID'];
    $State = $_POST['State'];
    $Status = $_POST['Status'];
    $RRN = $_POST['RRN'];
    $RefNum = $_POST['RefNum'];
    $ResNum = $_POST['ResNum'];
    $TerminalId = $_POST['TerminalId'];
    $TraceNo = $_POST['TraceNo'];
    $Amount = $_POST['Amount'];
    $Wage = $_POST['Wage'];
    $SecurePan = $_POST['SecurePan'];
    $HashedCardNumber = $_POST['HashedCardNumber'];
    $BankName = $_GET['BankName'];
    $Sec = $_GET['Sec'];
    $AmountRial = $objAclTools->de2Base64($Sec);

    $objBankSaman = new SamanPayment();

    if ($_POST['ResNum'] != $_GET['R']) {
        $objBankSaman->ReverseTransaction($_POST['ResNum']);
        JavaTools::JsAlert(FA_LC['res_number_not_equal']);
        JavaTools::JsAlertWithRefresh(FA_LC['payment_return_message'], 0, './?part=User&page=Checkout');
        exit();

    }

    if ($_POST['Amount'] != $AmountRial) {
        $objBankSaman->ReverseTransaction($_POST['ResNum']);
        JavaTools::JsAlert(FA_LC['payment_not_correct']);
        JavaTools::JsAlertWithRefresh(FA_LC['payment_return_message'], 0, './?part=User&page=Checkout');
        exit();

    }
    $SCondition = " RefNum = '$RefNum' ";
    if ($objORM->DataCount($SCondition, TableIWAPaymentState) > 0) {
        $objBankSaman->ReverseTransaction($_POST['ResNum']);
        JavaTools::JsAlert(FA_LC['payment_add_before']);
        JavaTools::JsAlertWithRefresh(FA_LC['payment_return_message'], 0, './?part=User&page=Checkout');
        exit();
    }


    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    
    
    $ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
    $ModifyDateNow = $objGlobalVar->Nu2EN($objTimeTools->jdate("Y/m/d"));

    $UserId = @$objGlobalVar->JsonDecode($objGlobalVar->SessionVarToJson())->_IWUserId;


    
    $PaymentIdKey = $IdKey;
// add to payment



    $HashedCardNumber = $_POST['HashedCardNumber'];
    $BankName = $_GET['BankName'];
    $AmountRial = $objAclTools->de2Base64($_GET['Sec']);

    $InSet = "";
    
    $InSet .= " Enabled = $Enabled ,";
    $InSet .= " ResitId = '$ResitId' ,";
    $InSet .= " State = '$State' ,";
    $InSet .= " Status = '$Status' ,";
    $InSet .= " Secvl = '$Sec' ,";
    $InSet .= " RRN = '$RRN' ,";
    $InSet .= " RefNum = '$RefNum' ,";
    $InSet .= " ResNum = '$ResNum' ,";
    $InSet .= " TerminalId = '$TerminalId' ,";
    $InSet .= " TraceNo = '$TraceNo' ,";
    $InSet .= " Amount = '$Amount' ,";
    $InSet .= " BankName = '$BankName' ,";
    $InSet .= " AmountRial = '$AmountRial' ,";
    $InSet .= " Wage = '$Wage' ,";
    $InSet .= " SecurePan = '$SecurePan' ,";
    $InSet .= " HashedCardNumber = '$HashedCardNumber' ,";
    $InSet .= " modify_ip = '$modify_ip' ,";
    
    
    $InSet .= " last_modify = '$now_modify' ,";
    $InSet .= " ModifyId = '$UserId' ";

    $objORM->DataAdd($InSet, TableIWAPaymentState);

    //add to main basket

    $SCondition = "  UserId = '$UserId' ";
    $objUserTempCart = $objORM->FetchAll($SCondition, '*', TableIWUserTempCart);

    foreach ($objUserTempCart as $UserTempCart) {
        $IdKeyCart = $objAclTools->IdKey();
        $InSet = "";
        $InSet .= " IdKey = '$IdKeyCart' ,";
        $InSet .= " Enabled = $Enabled ,";
        $InSet .= " ProductId = '$UserTempCart->ProductId' ,";
        $InSet .= " PaymentIdKey = '$PaymentIdKey' ,";
        $InSet .= " UserId = '$UserId' ,";
        $InSet .= " Size = '$UserTempCart->Size' ,";
        $InSet .= " ProductSizeId = '$UserTempCart->ProductSizeId' ";
        $InSet .= " Count = '$UserTempCart->Count' ,";
        $InSet .= " BasketIdKey = '$ResNum' ,";
        $InSet .= " ChkState = 'none' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        
        
        $InSet .= " last_modify = '$now_modify' ";

        $objORM->DataAdd($InSet, TableIWAUserMainCart);


        $USet = "PBuy = PBuy + 1";
        $objORM->DataUpdate("ProductId = $UserTempCart->ProductId", $USet, TableIWAPIProducts);
    }

// set bank payment

    $objBankSaman->VerifyTransaction($_POST['ResNum']);

    $SCondition = "id = '$UserId' and  Enabled = $Enabled ";
    $strProfile = $objORM->Fetch($SCondition, 'CellNumber,Name', TableIWUser);

    // SMS

    $objSms = new SmsConnections('3000505');
    $objSms->ResiveBasketSms($strProfile->CellNumber, $strProfile->Name, $ResNum);

    // count sms
    $expire_date = date("m-Y");
    $UCondition = " iw_company_id = 'e45fef12' and expire_date = '$expire_date' ";
    $USet = " Count = Count + 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWSMSAllConnect);

    $objORM->DeleteRow("  UserId = '$UserId' ", TableIWUserTempCart);


} else {
    echo $_POST['StateCode'];
}




