<?php
//RefBank.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$objGlobalVar = new GlobalVarTools();

$Enabled = true;

$objTimeTools = new TimeTools();
$objAclTools = new ACLTools();
$Disabled = false;
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

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

    $ResitId = $_POST['MID'];
    $State = $_POST['State'];
    $Status = $_POST['Status'];
    $RRN = $_POST['Rrn'];
    $Token = $_POST['Token'];
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
    $UserAddressId = $_GET['AddId'];
    $secUID = $_GET['SU'];
    $AmountRial = $objAclTools->de2Base64($Sec);

    $objBankSaman = new SamanPayment($secUID);

    if ($_POST['ResNum'] != $_GET['R']) {
        $objBankSaman->ReverseTransaction($_POST['ResNum']);

        JavaTools::JsAlertWithRefresh(FA_LC['res_number_not_equal'] . '. ' . FA_LC['payment_return_message'], 0, './?part=User&page=Checkout');
        exit();

    }

    if ($_POST['Amount'] != $AmountRial) {
        $objBankSaman->ReverseTransaction($_POST['ResNum']);

        JavaTools::JsAlertWithRefresh(FA_LC['payment_not_correct'] . '. ' . FA_LC['payment_return_message'], 0, './?part=User&page=Checkout');
        exit();

    }
    $SCondition = " RefNum = '$RefNum' ";
    if ($objORM->DataCount($SCondition, TableIWAPaymentState) > 0) {
        $objBankSaman->ReverseTransaction($_POST['ResNum']);
        //JavaTools::JsAlert(FA_LC['payment_add_before']);
        JavaTools::JsAlertWithRefresh(FA_LC['payment_add_before'] . '. ' . FA_LC['payment_return_message'], 0, './?part=User&page=Checkout');
        exit();
    }


    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    
    
    $ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
    $ModifyDateNow = $objGlobalVar->Nu2EN($objTimeTools->jdate("Y/m/d"));

    $UserId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
    if($UserId == ''){
        $UserId = $objGlobalVar->de2Base64($secUID);
    }elseif($objGlobalVar->de2Base64($secUID) != $UserId)
    {
        $objBankSaman->ReverseTransaction($_POST['ResNum']);
        JavaTools::JsAlertWithRefresh(FA_LC['user_data_error'] . '. ' . FA_LC['payment_return_message'], 0, './?type=usr&act=logout&q=y');
        exit();
    }
    $SCondition = "id = '$UserId' and  Enabled = $Enabled ";
    if (!$objORM->DataExist($SCondition, TableIWUser)) {
        $objBankSaman->ReverseTransaction($_POST['ResNum']);
        JavaTools::JsAlertWithRefresh(FA_LC['user_data_error'] . '. ' . FA_LC['payment_return_message'], 0, './?type=usr&act=logout&q=y');
        exit();
    }

    $objGlobalVar->setSessionVar('_IWUserId', $UserId);
    $objGlobalVar->setCookieVar('_IWUserId', $objAclTools->en2Base64($UserId, 1));


    
    $PaymentIdKey = $IdKey;
// add to payment


    $HashedCardNumber = $_POST['HashedCardNumber'];
    $BankName = $_GET['BankName'];
    $AmountRial = $objAclTools->de2Base64($_GET['Sec']);
    // basket
    $BasketIdKey = $ResNum;

    $InSet = "";
    
    $InSet .= " Enabled = $Enabled ,";
    $InSet .= " UserId = '$UserId' ,";
    $InSet .= " BasketIdKey = '$BasketIdKey' ,";
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
    $InSet .= " Token = '$Token' ,";
    $InSet .= " modify_ip = '$modify_ip' ,";
    
    
    $InSet .= " last_modify = '$now_modify' ,";
    $InSet .= " ModifyId = '$UserId' ";

    $objORM->DataAdd($InSet, TableIWAPaymentState);

    //add to main basket
    $intCountBasket = 0;

    $SCondition = "  UserId = '$UserId' ";
    $objUserTempCart = $objORM->FetchAll($SCondition, '*', TableIWUserTempCart);

    foreach ($objUserTempCart as $UserTempCart) {


        $SCondition2 = "  ProductId = '$UserTempCart->ProductId' ";
        $ProductCode = $objORM->Fetch($SCondition2, 'ProductCode', TableIWAPIProducts)->ProductCode;


        $IdKeyCart = $objAclTools->IdKey();
        $InSet = "";
        $InSet .= " IdKey = '$IdKeyCart' ,";
        $InSet .= " Enabled = $Enabled ,";
        $InSet .= " ProductId = '$UserTempCart->ProductId' ,";
        $InSet .= " PaymentIdKey = '$PaymentIdKey' ,";
        $InSet .= " UserId = '$UserId' ,";
        $InSet .= " Size = '$UserTempCart->Size' ,";
        $InSet .= " ProductSizeId = '$UserTempCart->ProductSizeId' , ";
        $InSet .= " ProductCode = '$ProductCode' , ";
        $InSet .= " Count = '$UserTempCart->Count' ,";
        $InSet .= " BasketIdKey = '$BasketIdKey' ,";
        $InSet .= " ChkState = 'none' ,";
        $InSet .= " UserAddressId = '$UserAddressId' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        
        
        $InSet .= " last_modify = '$now_modify' ";

        $objORM->DataAdd($InSet, TableIWAUserMainCart);


        $USet = "PBuy = PBuy + 1";
        $objORM->DataUpdate("ProductId = $UserTempCart->ProductId", $USet, TableIWAPIProducts);

        $intCountBasket++;
    }

// set bank payment

    $objBankSaman->VerifyTransaction($_POST['ResNum']);

    $SCondition = "id = '$UserId' and  Enabled = $Enabled ";
    $strProfile = $objORM->Fetch($SCondition, 'CellNumber,Name', TableIWUser);

    // SMS user

    $objSms = new SmsConnections('3000505');
    $objSms->ResiveBasketSms($strProfile->CellNumber, $strProfile->Name, $ResNum);


    // SMS Admins

    $objSms = new SmsConnections('3000505');

    $SCondition = "  Sms = 1 ";

    foreach ($objORM->FetchAll($SCondition, 'AdminId', TableIWAdminNotification) as $AdminNotification) {

        $AdminId = $AdminNotification->AdminId;
        $SCondition = "  IdKey = '$AdminId' ";
        $objSms->AdminNewBasketSms($objORM->Fetch($SCondition, 'CellNumber', TableIWAdmin)->CellNumber, $intCountBasket, $ResNum);
    }


    // count sms
    $strExpireDate = date("m-Y");
    $UCondition = " CompanyIdKey = 'e45fef12' and ExpireDate = '$strExpireDate' ";
    $USet = " Count = Count + 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWSMSAllConnect);

    $objORM->DeleteRow("  UserId = '$UserId' ", TableIWUserTempCart);


    // create invoice file


    $arrAllProductW = array();
    $intPackcount = 0;
    foreach ($objUserTempCart as $UserTempCart) {
        $strPricingPart = '';
        $strSizeSelect = '';
        $intCountSelect = 1;


        $strSizeSelect = $UserTempCart->Size;
        $UserTempCart->Count != '' ? $intCountSelect = $UserTempCart->Count : $intCountSelect = 1;
        $SCondition = "Enabled = $Enabled AND  ProductId = '$UserTempCart->ProductId' ";

        $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

        $strExistence = FA_LC["available"];


        $SArgument = "'$ListItem->id','c72cc40d','fea9f1bf'";
        $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
        $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
        $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
        $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;

        $intTotalPrice += $CarentCurrencyPrice * $intCountSelect;
        $strPricingPartTotal = $CarentCurrencyPrice * $intCountSelect;



        // Shipping part

        $PWIdKey = $ListItem->iw_product_weight_id;

        $objShippingTools = new ShippingTools((new MySQLConnection($objFileToolsDBInfo))->getConn());
        $arrListProductShip[] = array('IdKey' => $ListItem->id,
            'MainPrice' => $ListItem->MainPrice,
            'ValueWeight' => $objShippingTools->FindItemWeight($ListItem));


        $objArrayImage = explode('==::==', $ListItem->Content);
        $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

        $intImageCounter = 1;
        foreach ($objArrayImage as $image) {
            if (@strpos($ListItem->ImageSet, (string)$intImageCounter) === false) {

                unset($objArrayImage[$intImageCounter]);
            }
            $intImageCounter++;
        }
        $objArrayImage = array_values($objArrayImage);




        //invoice
        $strDateTime = $ModifyDate . ' ' . $ModifyTime;
        $IdKeyInvoice = $objAclTools->IdKey();
        $InSet = "";
        $InSet .= " IdKey = '$IdKeyInvoice' ,";
        $InSet .= " Enabled = $Enabled ,";
        $InSet .= " ProductId = '$UserTempCart->ProductId' ,";
        $InSet .= " PaymentIdKey = '$PaymentIdKey' ,";
        $InSet .= " UserId = '$UserId' ,";
        $InSet .= " Size = '$UserTempCart->Size' ,";
        $InSet .= " ProductSizeId = '$UserTempCart->ProductSizeId' , ";
        $InSet .= " ProductCode = '$ProductCode' , ";
        $InSet .= " Count = '$UserTempCart->Count' ,";
        $InSet .= " ItemPrice = $strPricingPartTotal ,";
        $InSet .= " BasketIdKey = '$BasketIdKey' ,";
        $InSet .= " UserAddressIdKey = '$UserAddressId' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        $InSet .= " SetDate = '$strDateTime' ,";
        
        
        $InSet .= " last_modify = '$now_modify' ";

        $objORM->DataAdd($InSet, TableIWAUserInvoice);


    }

//shipping calculate

    if (count((array)$arrListProductShip) > 0) {
        $intTotalShipping = $objShippingTools->Shipping($arrListProductShip, 'پوند', 'تومان');
        $intPackcount = count($objShippingTools->Sort2Pack($arrListProductShip));
    } else {
        $intTotalShipping = 0;
        $intPackcount = 0;
        JavaTools::JsAlertWithRefresh(FA_LC['basket_is_empty'], 0, './?part=User&page=Account');
        exit();
    }

// total account

    $intTotalPriceShipping = $intTotalShipping + $intTotalPrice;
    if ($intTotalPrice != 0) {
        $intTotalPrice = $objGlobalVar->NumberFormat($intTotalPrice, 0, ".", ",");
        $intTotalPrice = $objGlobalVar->Nu2FA($intTotalPrice);
    }

    if ($intTotalShipping != 0) {
        $intTotalShipping = $objGlobalVar->NumberFormat($intTotalShipping, 0, ".", ",");
        $intTotalShipping = $objGlobalVar->Nu2FA($intTotalShipping);
    }
    $intTotalPriceShippingEn = $intTotalPriceShipping;
    if ($intTotalPriceShipping != 0) {
        $intTotalPriceShipping = $objGlobalVar->NumberFormat($intTotalPriceShipping, 0, ".", ",");
        $intTotalPriceShipping = $objGlobalVar->Nu2FA($intTotalPriceShipping);
    }

    if ($intPackcount != 0) {
        $intPackcount = $objGlobalVar->NumberFormat($intPackcount, 0, ".", ",");
        $intPackcount = $objGlobalVar->Nu2FA($intPackcount);
    }

    // total invoice

    $UCondition = " PaymentIdKey = '$PaymentIdKey' and BasketIdKey = '$BasketIdKey' ";
    $USet = " TotalPrice = '$intTotalPrice' , ";
    $USet .= " TotalShipping = '$intTotalShipping' ,";
    $USet .= " PackCount = '$intPackcount' ,";
    $USet .= " TotalPriceShipping = '$intTotalPriceShipping' ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAUserInvoice);

    JavaTools::JsAlertWithRefresh(FA_LC['payment_ok__2'] . '. ' . FA_LC['tanks_for_shopping'], 0, './?part=User&page=ShopList');
    exit();

}



