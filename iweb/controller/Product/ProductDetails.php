<?php
//ProductDetails.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$Disabled = false;
$objAclTools = new ACLTools();
$objGlobalVar = new GlobalVarTools();


if (isset($_POST['SubmitM'])) {

    $strSizeId = $_POST['Size'];
    $arrSizeId = explode('|',$strSizeId);
    $ProductSizeId = $arrSizeId[0];
    $Size = $arrSizeId[1];

    $Count = $_POST['Count'];
    $ProductId = $_POST['ProductId'];
    $expire_date = date("m-d-Y", strtotime('+1 day'));
    $UserId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
    $UserSessionId = session_id();

    $Enabled = true;
    $SCondition = " ( UserId = '$UserId' or UserSessionId = '$UserSessionId' ) and  ProductId = $ProductId and  expire_date = '$expire_date' ";

    if ($objORM->DataExist($SCondition, TableIWUserTempCart)) {
        JavaTools::JsAlertWithRefresh(FA_LC['enter_product_exist'], 0, '');
        exit();

    } else {

        $objTimeTools = new TimeTools();
        $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        
        


        $now_modify = date("Y-m-d H:i:s");

        $InSet = "";
        $InSet .= " Size = '$Size' ,";
        $InSet .= " Enabled = $Enabled ,";
        $InSet .= " Count = '$Count' ,";
        $InSet .= " ProductId = $ProductId ,";
        $InSet .= " ProductSizeId = '$ProductSizeId' ,";
        $InSet .= " expire_date = '$expire_date' ,";
        $InSet .= " UserId = '$UserId' ,";
        $InSet .= " UserSessionId = '$UserSessionId' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        
        
        $InSet .= " last_modify = '$now_modify' ";

        $objORM->DataAdd($InSet, TableIWUserTempCart);

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', ''));
        exit();

    }


}


if (isset($_GET['IdKey'])) {

    $IdKey = $_GET['IdKey'];
    $objReqular = new Regularization();
    $objTimeTools = new TimeTools();

    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    
    
    $now_modify = date("Y-m-d H:i:s");
    $ModifyId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));


    $SCondition = "  Content IS NOT NULL AND id = $IdKey AND Enabled = $Enabled And AdminOk = 1  ";

    $ModifyDateNow = $objAclTools->Nu2EN($objTimeTools->jdate("Y/m/d"));

    if ($objORM->DataExist($SCondition, TableIWAPIProducts)) {

        // count view and score

        $USet = "PView = PView + 1";
        $objORM->DataUpdate($SCondition, $USet, TableIWAPIProducts);

        $objProduct = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

        $strOtherData = '';

        //   if ($objProduct->ApiContent == '' or $objProduct->ApiContent == NULL or $objProduct->ModifyDate != $ModifyDateNow) {


        // API Count and Connect
        $objAsos = new AsosConnections();

        $ApiContent = $objAsos->ProductsDetail($objProduct->ProductId);
        $expire_date = date("m-Y");
        $UCondition = " iw_company_id = $obj_product->iw_company_id and expire_date = '$expire_date' ";
        $USet = " Count = Count + 1 ";
        $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);
        $objProductData = $objReqular->JsonDecodeArray($objReqular->deBase64($ApiContent));

        $ProductType = $objProductData['productType']['name'] ?? null;





        //Color
        $arrColor = array();
        $arrColorDis = array();
        $strColor = '';
        if (is_array(@$objProductData['variants'])) {
            foreach ($objProductData['variants'] as $Color) {
                if (!$Color['isInStock'])
                    $arrColorDis[] = $Color['colour'];

                $arrColor[] = $Color['colour'];
            }
            $arrColor = array_unique($arrColor);
            $strColor = implode(",", $arrColor);
        }

//Size
        $arrSize = array();
        $arrSizeDis = array();
        $strSize = '';
        $strSizeDis = '';
        if (is_array(@$objProductData['variants'])) {
            foreach ($objProductData['variants'] as $Size) {
                if (!$Size['isInStock'])
                    $arrSizeDis[] = $Size['brandSize'];

                $arrSize[$Size['id']] = $Size['brandSize'];

            }
            $arrSize = array_unique($arrSize);
            $arrSizeDis = array_unique($arrSizeDis);
            $arrSize = array_diff($arrSize, $arrSizeDis);

            $strSize = implode(",", $arrSize);
            $strSizeDis = implode(",", $arrSizeDis);
        }

        $parts = parse_url($objReqular->FindUrlInString($objProductData['description']));
        $arrPath = array_filter(explode("/", $parts['path']));
        unset($arrPath[count($arrPath)]);


        $objProductData['price']['previous']['value'] != null ? $ApiLastPrice = $objProductData['price']['previous']['value'] : $ApiLastPrice = 0;


        $arrCatId = explode(",", $objProduct->CatId);
        if (is_array($arrCatId)) {
            $arrCatId = array_unique($arrCatId);
            $strCatId = implode(",", $arrCatId);
        } else {
            $strCatId = $objProduct->CatId;
        }




        $USet = " ApiContent = '$ApiContent', ";
        $USet .= " LastPrice = $ApiLastPrice, ";
        $USet .= " ProductType = '$ProductType', ";
        $USet .= " CatId = '$strCatId', ";
        $USet .= " PGender = '$arrPath[1]' ,";
        $USet .= " PCategory = '$arrPath[2]' ,";
        $USet .= " Color = '$strColor', ";
        $USet .= " Size = '$strSize', ";
        $USet .= " SizeDis = '$strSizeDis', ";
        $USet .= " modify_ip = '$modify_ip' ,";
        
        
        $USet .= " last_modify = '$now_modify' ,";
        $USet .= " RootDateCheck = '$ModifyStrTime' ,";
        $USet .= " modify_id = $ModifyId ";

        if (isset($arrPath[3]))
            $USet .= ", PGroup = '$arrPath[3]' ";
        if (isset($arrPath[4]))
            $USet .= ", PGroup2 = '$arrPath[4]' ";

        if (!$objProductData['isInStock']){
            $USet .= ", Enabled = $Disabled";

        }else{
            $USet .= ", Enabled = $Enabled";
        }


        $objORM->DataUpdate($SCondition, $USet, TableIWAPIProducts);

        $strOtherData = $objProductData;
/*
           } else {
              $strOtherData = $objReqular->JsonDecodeArray($objReqular->deBase64($objProduct->ApiContent));
            }
*/
        $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
        $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);

        $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

        $objArrayImage = explode("==::==", $objProduct->Content);
        $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

        $intImageCounter = 1;
        foreach ($objArrayImage as $image) {
            if (@strpos($objProduct->ImageSet, (string)$intImageCounter) === false) {

                unset($objArrayImage[$intImageCounter]);
            }
            $intImageCounter++;
        }
        $objArrayImage = array_values($objArrayImage);


        $strPricingPart = '';
        $SArgument = "'$objProduct->IdKey','c72cc40d','fea9f1bf'";
        $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
        $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
        $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
        $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;

        $boolChange = 0;

        if ($CarentCurrencyPrice != $PreviousCurrencyPrice and $PreviousCurrencyPrice != 0)
            $boolChange = 1;

        if ($CarentCurrencyPrice != null) {
            $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
            $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
            $strPricingPart .= '<span class="new-price">' . $CarentCurrencyPrice . '</span>';
        }

        if ($PreviousCurrencyPrice != null and $boolChange) {
            $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
            $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
            $strPricingPart .= '<span class="old-price">' . $PreviousCurrencyPrice . '</span>';
        }

        // shipping price

        $strShippingPrice = '';
        $PWIdKey = $objProduct->iw_product_weight_id;

        $objShippingTools = new ShippingTools((new MySQLConnection($objFileToolsDBInfo))->getConn());



        $intTotalShipping = $objShippingTools->FindBasketWeightPrice($objShippingTools->FindItemWeight($objProduct), $objProduct->MainPrice, 'پوند', 'تومان');

        if ($intTotalShipping != 0) {
            $intTotalShipping = $objGlobalVar->NumberFormat($intTotalShipping, 0, ".", ",");
            $strShippingPrice = $objGlobalVar->Nu2FA($intTotalShipping);
        }

        // wieght

        $strShippingWeight = $objShippingTools->FindItemWeight($objProduct) . ' KG ';


    }


}

