<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../../../iassets/include/DBLoader.php";

$now_modify = date("Y-m-d H:i:s");
$modify_ip = (new IPTools('../../../idefine/'))->getUserIP();

if (!empty($_POST['user_id']) or !empty($_POST['secUID'])) {

    if (!empty($_POST['user_id']) and ((int) $_POST['user_id']) > 0) {

        $user_id = (int) $_POST['user_id'];
    } elseif (!empty($_POST['secUID'])) {
        $user_id = (int) (base64_decode(base64_decode($_POST['secUID'])));
    }


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
    $UserAddressId = $_POST['UserAddressId'];
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
    $shopping_cart = $objORM->Fetch(" iw_user_id = $user_id and iw_user_order_status_id = $none_status_id ", "id", TableIWUserShoppingCart);

    if (empty($shopping_cart->id)) {
        $objBankSaman->ReverseTransaction($ResNum);
        $status = array(
            'stat' => false,
            'code' => 6
        );
        echo json_encode($status);
        exit();
    }

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
    $InSet .= " iw_user_shopping_cart_id = $shopping_cart->id ,";
    $InSet .= " last_modify = '$now_modify' ,";
    $InSet .= " modify_id = $user_id , ";
    $InSet .= " modify_ip = '$modify_ip' ";

    $objORM->DataAdd($InSet, TableIWAPaymentState);
    $payment_id = $objORM->LastId();






    $objUserTempCart = $objORM->FetchAll(" iw_user_id = $user_id  ", '*', TableIWUserTempCart);

    $bought_status_id = $objORM->Fetch("status = 'bought'", "id", TableIWUserOrderStatus)->id;

    foreach ($objUserTempCart as $UserTempCart) {


        // create invoice file

        $obj_product_variants = @$objORM->Fetch(
            "product_id = $UserTempCart->product_id",
            'displaySizeText,sizeOrder,brandSize,colour,isInStock,price_current,price_previous,iw_api_products_id,product_id,id',
            TableIWApiProductVariants
        );



        $obj_product = $objORM->Fetch(
            "id = $obj_product_variants->iw_api_products_id",
            "id,Name,Content,ImageSet,url_gender,url_category,url_group,id,iw_product_weight_id,iw_api_brands_id,iw_api_product_type_id",
            TableIWAPIProducts
        );


        $str_change = " PBuy = PBuy + 1 , iw_api_products_id = $obj_product->id ";
        $type_condition = "iw_api_products_id = $obj_product->id";
        if (!$objORM->DataExist($type_condition, TableIWApiProductStatus, 'iw_api_products_id')) {

            $objORM->DataAdd($str_change, TableIWApiProductStatus);
        } else {

            $objORM->DataUpdate($type_condition, $str_change, TableIWApiProductStatus);
        }

        for ($i = 0; $i < $UserTempCart->qty; $i++) {

            //invoice
            $InSet = " Enabled = 1 ,";
            $InSet .= " product_id = '$UserTempCart->product_id' ,";
            $InSet .= " payment_id = $payment_id  ,";
            $InSet .= " user_id = $user_id ,";
            $InSet .= " size = '$obj_product_variants->brandSize' ,";
            $InSet .= " price = $UserTempCart->price ,";
            $InSet .= " shopping_cart_id = $shopping_cart->id ,";
            $InSet .= " user_order_status_id = $bought_status_id ,";
            $InSet .= " currencies_conversion_id = $UserTempCart->currencies_conversion_id ,";
            $InSet .= " iw_user_address = $UserAddressId ,";
            $InSet .= " promo_code = '$UserTempCart->promo_code',";
            $InSet .= " api_products_id = $obj_product->id,";
            $InSet .= " last_modify = '$now_modify' ,";
            $InSet .= " modify_id = $user_id, ";
            $InSet .= " modify_ip = '$modify_ip' ";

            $objORM->DataAdd($InSet, TableIWAUserInvoice);

            $invoice_id = $objORM->LastId();


            $in_set = " user_id = $user_id , product_id = '$UserTempCart->product_id',
                cart_id = $shopping_cart->id ,size = '$obj_product_variants->brandSize' ,
                address_id = $UserAddressId , invoice_id = $invoice_id  ";
            $objORM->DataAdd($in_set, TableIWShippingProduct);

        }
    }




    $objORM->DataUpdate(
        "id = $shopping_cart->id",
        "iw_user_order_status_id = $bought_status_id , iw_user_address = $UserAddressId ",
        TableIWUserShoppingCart
    );



    $objORM->DeleteRow(" iw_user_id = $user_id ", TableIWUserTempCart);



    // set bank payment

    $objBankSaman->VerifyTransaction($ResNum);


    // SMS user

    $strProfile = $objORM->Fetch("id = $user_id  ", 'CellNumber,Name', TableIWUser);

    $objSms = new SmsConnections('3000505');
    $objSms->ResiveBasketSms($strProfile->CellNumber, $strProfile->Name, $shopping_cart->id);

    $objSms = new SmsConnections('3000505');
    $objSms->ResiveBasketSms("09121501993", $strProfile->Name, $shopping_cart->id);


    // count sms
    $expire_date = date("m-Y");
    $UCondition = " iw_company_id = $iw_company_id and expire_date = '$expire_date' ";
    $USet = " all_count = all_count + 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWSMSAllConnect);




    if ($Amount == $AmountRial) {
        $objBankSaman->ReverseTransaction($ResNum);
        $status = array(
            'stat' => true,
            'code' => 1
        );
        echo json_encode($status);
        exit();

    }


} else {
    $objBankSaman->ReverseTransaction($ResNum);
    $status = array(
        'stat' => false,
        'code' => 6
    );
    echo json_encode($status);
}