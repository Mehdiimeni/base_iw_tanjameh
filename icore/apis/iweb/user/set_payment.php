<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

$now_modify = date("Y-m-d H:i:s");
$modify_ip = (new IPTools('../../../idefine/'))->getUserIP();

if (!empty($_POST['user_id'])) {


    $user_id = $_POST['user_id'];
    $secUID = $_POST['secUID'];
    $ResNum = $_POST['ResNum'];
    $Amount = $_POST['Amount'];
    $AmountRial = $_POST['AmountRial'];
    $R = $_POST['R'];
    $RefNum = $_POST['RefNum'];
    $HashedCardNumber = $_POST['HashedCardNumber'];
    $BankName = $_POST['BankName'];
    $ResitId = $_POST['ResitId'];
    $State = $_POST['State'];
    $Status = $_POST['Status'];
    $Sec = $_POST['Sec'];
    $RRN = $_POST['RRN'];
    $TerminalId = $_POST['TerminalId'];
    $TraceNo = $_POST['TraceNo'];
    $Wage = $_POST['Wage'];
    $SecurePan = $_POST['SecurePan'];
    $Token = $_POST['Token'];
    $iw_company_id = $_POST['iw_company_id'];

    $objBankSaman = new SamanPayment($secUID);

    if ($ResNum != $R) {
        $objBankSaman->ReverseTransaction($ResNum);
        $status = array(
            'stat' => false,
            'code' => 1
        );
        echo json_encode($status);
        exit();

    }

    if ($Amount != $AmountRial) {
        $objBankSaman->ReverseTransaction($ResNum);
        $status = array(
            'stat' => false,
            'code' => 2
        );
        echo json_encode($status);
        exit();

    }

    if ($objORM->DataCount(" RefNum = '$RefNum' ", TableIWAPaymentState) > 0) {
        $objBankSaman->ReverseTransaction($ResNum);
        $status = array(
            'stat' => false,
            'code' => 3
        );
        echo json_encode($status);
        exit();
    }


    if (base64_decode(base64_decode($secUID)) != $user_id) {
        $objBankSaman->ReverseTransaction($ResNum);
        $status = array(
            'stat' => false,
            'code' => 4
        );
        echo json_encode($status);
        exit();
    }

    if (!$objORM->DataExist("id = $user_id and  Enabled = 1 ", TableIWUser)) {
        $objBankSaman->ReverseTransaction($ResNum);
        $status = array(
            'stat' => false,
            'code' => 5
        );
        echo json_encode($status);
        exit();
    }


    $none_status_id = $objORM->Fetch("status = 'none'", "id", TableIWUserOrderStatus)->id;
    $shopping_cart_id = $objORM->Fetch(" iw_user_id = $user_id and iw_user_order_status_id = $none_status_id ", "id", TableIWUserShoppingCart)->id;
    $modify_ip = (new IPTools('../../../idefine/'))->getUserIP();
    $now_modify = date("Y-m-d H:i:s");



    // add to payment


    $InSet = " Enabled = 1 ,";
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
    $InSet .= " iw_user_id = $user_id ,";
    $InSet .= " iw_user_shopping_cart_id = $shopping_cart_id ,";
    $InSet .= " modify_ip = '$modify_ip' ,";
    $InSet .= " modify_ip = '$modify_ip' ";

    $objORM->DataAdd($InSet, TableIWAPaymentState);


    //add to main basket
    $intCountBasket = 0;

    $objUserTempCart = $objORM->FetchAll(" iw_user_id = $user_id and iw_user_shopping_cart_id = $shopping_cart_id ", '*', TableIWUserTempCart);

    foreach ($objUserTempCart as $UserTempCart) {


        $str_change = "
            Enabled= 1,
            product_id= $UserTempCart->product_id,
            qty=$UserTempCart->qty,
            price='$UserTempCart->price',
            iw_user_id= $user_id,
            currencies_conversion_id = $UserTempCart->currencies_conversion_id ,
            promo_code = '$UserTempCart->promo_code',
            iw_api_products_id = $UserTempCart->iw_api_products_id,
            iw_user_shopping_cart_id = $shopping_cart_id,
            last_modify = '$now_modify',
            modify_id = $user_id,
            modify_ip = '$modify_ip'";

        $objORM->DataAdd($str_change, TableIWAUserMainCart);


        $objORM->DataUpdate(
            "ProductId = $UserTempCart->product_id",
            "PBuy = PBuy + 1",
            TableIWAPIProducts
        );

        $intCountBasket++;
    }

    $bought_status_id = $objORM->Fetch("status = 'bought'", "id", TableIWUserOrderStatus)->id;

    $objORM->DataUpdate(
        "id = $shopping_cart_id",
        "iw_user_order_status_id = $bought_status_id",
        TableIWUserShoppingCart
    );

    $objORM->DeleteRow(" iw_user_id = $user_id and iw_user_shopping_cart_id = $shopping_cart_id ", TableIWUserTempCart);


    // set bank payment

    $objBankSaman->VerifyTransaction($ResNum);

    
    // SMS user

    $strProfile = $objORM->Fetch("id = $user_id  ", 'CellNumber,Name', TableIWUser);

    $objSms = new SmsConnections('3000505');
    $objSms->ResiveBasketSms($strProfile->CellNumber, $strProfile->Name, $ResNum);


    // count sms
    $expire_date = date("m-Y");
    $UCondition = " iw_company_id = $iw_company_id and expire_date = '$expire_date' ";
    $USet = " all_count = all_count + 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWSMSAllConnect);


        // create invoice file


        $arrAllProductW = array();
        $intPackcount = 0;
        foreach ($objUserTempCart as $UserTempCart) {
            $strPricingPart = '';
            $strSizeSelect = '';
            $intCountSelect = 1;
    
    
            $strSizeSelect = $UserTempCart->Size;
            $UserTempCart->Count != '' ? $intCountSelect = $UserTempCart->Count : $intCountSelect = 1;
            $SCondition = "Enabled = '$Enabled' AND  ProductId = '$UserTempCart->ProductId' ";
    
            $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);
    
            $strExistence = FA_LC["available"];
    
    
            $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
            $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
            $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
            $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
            $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;
    
            $intTotalPrice += $CarentCurrencyPrice * $intCountSelect;
            $strPricingPartTotal = $CarentCurrencyPrice * $intCountSelect;
    
    
    
            // Shipping part
    
            $PWIdKey = $ListItem->WeightIdKey;
    
            $objShippingTools = new ShippingTools((new MySQLConnection($objFileToolsDBInfo))->getConn());
            $arrListProductShip[] = array('IdKey' => $ListItem->IdKey,
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
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " ProductId = '$UserTempCart->ProductId' ,";
            $InSet .= " PaymentIdKey = '$PaymentIdKey' ,";
            $InSet .= " UserIdKey = '$UserIdKey' ,";
            $InSet .= " Size = '$UserTempCart->Size' ,";
            $InSet .= " ProductSizeId = '$UserTempCart->ProductSizeId' , ";
            $InSet .= " ProductCode = '$ProductCode' , ";
            $InSet .= " Count = '$UserTempCart->Count' ,";
            $InSet .= " ItemPrice = $strPricingPartTotal ,";
            $InSet .= " BasketIdKey = '$BasketIdKey' ,";
            $InSet .= " UserAddressIdKey = '$UserAddressId' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " SetDate = '$strDateTime' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ";
    
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




} else {
    echo false;
}