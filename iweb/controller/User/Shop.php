<?php
//Shop.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$objGlobalVar = new GlobalVarTools();

$Enabled = BoolEnum::BOOL_TRUE();
$Disabled = BoolEnum::BOOL_FALSE();

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$objReqular = new Regularization();
$objTimeTools = new TimeTools();
$objAclTools = new ACLTools();

$ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
$ModifyTime = $objTimeTools->jdate("H:i:s");
$ModifyDate = $objTimeTools->jdate("Y/m/d");
$ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
$ModifyId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$ModifyDateNow = $objGlobalVar->Nu2EN($objTimeTools->jdate("Y/m/d"));

if (isset($_POST['SubmitM'])) {

    $arrSize = array();
    $arrCount = array();
    $arrProductId = array();

    $arrSize = $_POST['Size'];
    $arrCount = $_POST['PCount'];
    $arrProductId = $_POST['ProductId'];

    $intCounter = 0;

    foreach ($arrProductId as $ProductId) {

        $strSizeId = $arrSize[$intCounter];
        $arrSizeId = explode('|', $strSizeId);
        $ProductSizeId = $arrSizeId[0];
        $Size = $arrSizeId[1];

        $Count = $arrCount[$intCounter];

        $strExpireDate = date("m-d-Y", strtotime('+1 day'));
        $UserIdKey = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
        $UserSessionId = session_id();


        $Enabled = BoolEnum::BOOL_TRUE();


        $objTimeTools = new TimeTools();
        $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $ModifyTime = $objTimeTools->jdate("H:i:s");
        $ModifyDate = $objTimeTools->jdate("Y/m/d");


        $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;

        $UCondition = " ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' ) and  ProductId = '$ProductId'  ";

        $USet = "";
        $USet .= " Size = '$Size' ,";
        $USet .= " ProductSizeId = '$ProductSizeId' ,";
        $USet .= " Enabled = '$Enabled' ,";
        $USet .= " Count = '$Count' ,";
        $USet .= " ExpireDate = '$strExpireDate' ,";
        $USet .= " UserIdKey = '$UserIdKey' ,";
        $USet .= " UserSessionId = '$UserSessionId' ,";
        $USet .= " ModifyIP = '$ModifyIP' ,";
        $USet .= " ModifyTime = '$ModifyTime' ,";
        $USet .= " ModifyDate = '$ModifyDate' ,";
        $USet .= " ModifyStrTime = '$ModifyStrTime' ";


        $objORM->DataUpdate($UCondition, $USet, TableIWUserTempCart);

        $intCounter++;

    }

    JavaTools::JsTimeRefresh(0, '?part=User&page=Checkout');
    exit();


}
$_POST = array();

$strProductsShop = '';
$intTotalPrice = 0;
$intTotalShipping = 0;

$arrAddToCart = '';

// url
$ActualPageLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$UserIdKey = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$UserSessionId = session_id();

$SCondition = "  ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' )  and ProductId != ''  ";
$objUserTempCart = $objORM->FetchAll($SCondition, '*', TableIWUserTempCart);


//array wig

$arrListProductShip = array();
$intPackcount = 0;
$boolAllowCheckout = true;
$intCountWeight = 0;

foreach ($objUserTempCart as $UserTempCart) {

    if($UserIdKey != '') {
        $UCondition = " ( UserIdKey = '' and UserSessionId = '$UserSessionId' ) and  ProductId = '$UserTempCart->ProductId'  ";
        $USet = " UserIdKey = '$UserIdKey' ";
        $objORM->DataUpdate($UCondition, $USet, TableIWUserTempCart);
    }


    $strPricingPart = '';
    $strSizeSelect = '';
    $intCountSelect = 1;
    $boolAllowCheckoutLogin = false;

    if ($UserTempCart->Size == '' or $UserTempCart->Count == '' or $UserTempCart->ProductSizeId == '')
        $boolAllowCheckout = false;

    if ($objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey')) !== null and $UserTempCart->UserIdKey == '')
        $boolAllowCheckoutLogin = true;

    $strSizeSelect = $UserTempCart->Size;
    $UserTempCart->Count != '' ? $intCountSelect = $UserTempCart->Count : $intCountSelect = 1;
    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$UserTempCart->ProductId' ";

    $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);
    $strExistence = FA_LC["available"];

    // API Count and Connect
    $objAsos = new AsosConnections();

    $ApiContent = $objAsos->ProductsDetail($ListItem->ProductId);
    $strExpireDate = date("m-Y");
    $UCondition = " CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ";
    $USet = " Count = Count + 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);
    $objProductData = $objReqular->JsonDecodeArray($objReqular->deBase64($ApiContent));


    if (!$objProductData['isInStock']) {
        $strExistence = FA_LC["unavailable"];
        $objORM->DeleteRow(" ProductId = '$ListItem->ProductId' and ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' )  ", TableIWUserTempCart);
    }

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
        $strSize = implode(",", $arrSize);
        $strSizeDis = implode(",", $arrSizeDis);
    }

    $parts = parse_url($objReqular->FindUrlInString($objProductData['description']));
    $arrPath = array_filter(explode("/", $parts['path']));
    unset($arrPath[count($arrPath)]);

    $arrCatId = explode(",", $ListItem->CatId);
    if (is_array($arrCatId)) {
        $arrCatId = array_unique($arrCatId);
        $strCatId = implode(",", $arrCatId);
    } else {
        $strCatId = $ListItem->CatId;
    }


    $objProductData['price']['previous']['value'] != null ? $ApiLastPrice = $objProductData['price']['previous']['value'] : $ApiLastPrice = 0;
    $USet = " ApiContent = '$ApiContent', ";
    $USet .= " LastPrice = $ApiLastPrice, ";
    $USet .= " ProductType = '$ProductType', ";
    $USet .= " CatId = '$strCatId', ";
    $USet .= " PGender = '$arrPath[1]' ,";
    $USet .= " PCategory = '$arrPath[2]' ,";
    $USet .= " Color = '$strColor', ";
    $USet .= " Size = '$strSize', ";
    $USet .= " SizeDis = '$strSizeDis', ";
    $USet .= " ModifyIP = '$ModifyIP' ,";
    $USet .= " ModifyTime = '$ModifyTime' ,";
    $USet .= " ModifyDate = '$ModifyDate' ,";
    $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
    $USet .= " RootDateCheck = '$ModifyStrTime' ,";
    $USet .= " ModifyId = '$ModifyId' ";

    if (isset($arrPath[3]))
        $USet .= ", PGroup = '$arrPath[3]' ";
    if (isset($arrPath[4]))
        $USet .= ", PGroup2 = '$arrPath[4]' ";

    if (!$objProductData['isInStock'])
        $USet .= ", Enabled = $Disabled";


    $objORM->DataUpdate($SCondition, $USet, TableIWAPIProducts);

    $strOtherData = $objProductData;


    // } else {
    //      $strOtherData = $objReqular->JsonDecodeArray($objReqular->deBase64($ListItem->ApiContent));
    //  }

    //Size
    $strSize = '';
    $arrSize = array();
    foreach ($strOtherData['variants'] as $Size) {
        if (!$Size['isInStock'])
            continue;

        $arrSize[$Size['id']] = $Size['brandSize'];
    }
    foreach (array_unique($arrSize) as $id => $Size) {

        $strSelected = '';
        if ($strSizeSelect == $Size)
            $strSelected = 'selected';

        $strSize .= '<option ' . $strSelected . '  value="' . $id . '|' . $Size . '">' . $Size . '</option>';
    }
    if ($objProductData['isInStock']) {
        $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
        $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
        $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
        $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
        $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;

        $intTotalPrice += $CarentCurrencyPrice * $intCountSelect;
        $strPricingPartTotal = $CarentCurrencyPrice * $intCountSelect;
        if ($CarentCurrencyPrice != null) {
            $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
            $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
            $strPricingPart = '<span class="new-price">' . $CarentCurrencyPrice . '</span>';
        }

        if ($strPricingPartTotal != null) {
            $strPricingPartTotal = $objGlobalVar->NumberFormat($strPricingPartTotal, 0, ".", ",");
            $strPricingPartTotal = $objGlobalVar->Nu2FA($strPricingPartTotal);
            $strPricingPartTotal = '<span class="new-price">' . $strPricingPartTotal . '</span>';
        }

        // Shipping part

        $PWIdKey = $ListItem->WeightIdKey;

        $objShippingTools = new ShippingTools((new MySQLConnection($objFileToolsDBInfo))->getConn());
        $arrListProductShip[] = array('IdKey' => $ListItem->IdKey,
            'MainPrice' => $ListItem->MainPrice,
            'ValueWeight' => $objShippingTools->FindItemWeight($ListItem));

    }


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


    $strProductsShop .= '<tr><td class="product-thumbnail">';
    $strProductsShop .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsShop .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 120, 'class="main-image"');
    $strProductsShop .= '</a></td><td class="product-name">';
    $strProductsShop .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsShop .= $ListItem->Name;
    $strProductsShop .= '</a><ul>';
    $strProductsShop .= '<li>' . FA_LC["color"] . ': <span>' . $strOtherData['variants'][0]['colour'] . '</span></li>';
    $strProductsShop .= '<li>' . FA_LC["size"] . ': <span>' . $strSizeSelect . '</span></li>';
    $strProductsShop .= '<li>' . FA_LC["type"] . ': <span>' . $strOtherData['productType']['name'] . '</span></li>';
    $strProductsShop .= '<li>' . FA_LC["brand"] . ':<span> ' . $strOtherData['brand']['name'] . '</span></li>';
    $strProductsShop .= '</ul></td><td class="products-size-wrapper" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsShop .= $strExistence;
    $strProductsShop .= '</td><td  class="products-size-wrapper" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsShop .= '<div ><select  name="Size[]" class="form-control">' . $strSize . '</select></div>';
    $strProductsShop .= '</td><td class="product-price" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsShop .= '<span class="unit-amount">' . $strPricingPart . '</span>';
    $strProductsShop .= '</td><td class="product-price" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsShop .= '<span class="unit-amount">' . $arrListProductShip[$intCountWeight]['ValueWeight']. ' KG</span>';
    $strProductsShop .= '</td><td class="product-quantity" style="margin:5px; padding:5px; text-align: center; "><div class="input-counter"><span class="minus-btn"> <i class="bx bx-minus"></i></span>';
    $strProductsShop .= '<input name="PCount[]" type="text" min="1" value="' . $intCountSelect . '"><span class="plus-btn"><i class="bx bx-plus"></i></span></div></td>';
    $strProductsShop .= '<td class="product-subtotal" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsShop .= '<a href="#" data-rebasket="' . $ListItem->ProductId . '" class="remove"><i class="bx bx-trash"></i></a>';
    $strProductsShop .= '</td></tr>';
    $strProductsShop .= '<input name="ProductId[]" type="hidden" value="' . $ListItem->ProductId . '">';

    $intCountWeight++;
}

//shipping calculate
if (count((array)$arrListProductShip) > 0) {
    $intTotalShipping = $objShippingTools->Shipping($arrListProductShip, 'پوند', 'تومان');
    $intPackcount = count($objShippingTools->Sort2Pack($arrListProductShip));
}else
{
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

if ($intTotalPriceShipping != 0) {
    $intTotalPriceShipping = $objGlobalVar->NumberFormat($intTotalPriceShipping, 0, ".", ",");
    $intTotalPriceShipping = $objGlobalVar->Nu2FA($intTotalPriceShipping);
}

if ($intPackcount != 0) {
    $intPackcount = $objGlobalVar->NumberFormat($intPackcount, 0, ".", ",");
    $intPackcount = $objGlobalVar->Nu2FA($intPackcount);
}


if($intTotalPriceShipping == 0)
    $boolAllowCheckout = false;

