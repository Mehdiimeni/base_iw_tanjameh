<?php
//Checkout.php
require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$objGlobalVar = new GlobalVarTools();

$UserIdKey = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$UserSessionId = session_id();

if ($UserIdKey == '') {
    
    JavaTools::JsTimeRefresh(0, './?part=User&page=Login');
    exit();
}
$objTimeTools = new TimeTools();
$Enabled = BoolEnum::BOOL_TRUE();
$Disabled = BoolEnum::BOOL_FALSE();

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');



$ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
$ModifyTime = $objTimeTools->jdate("H:i:s");
$ModifyDate = $objTimeTools->jdate("Y/m/d");
$ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
$ModifyDateNow = $objGlobalVar->Nu2EN($objTimeTools->jdate("Y/m/d"));





//Addresses
$strAdrresses = '<option readonly="readonly" selected value=""><b>' . FA_LC['select_address'] . '</b> </option>';
$boolAddress = 1;
$SCondition = " Enabled = '$Enabled' and UserIdKey = '$UserIdKey' ORDER BY IdRow ";
foreach ($objORM->FetchAll($SCondition, 'NicName,Address,IdKey', TableIWUserAddress) as $ListItem) {
    $strAdrresses .= '<option  value="' . $ListItem->IdKey . '"><b>' . $ListItem->NicName . '</b> </option>';

}
if ($objORM->DataCount($SCondition, TableIWUserAddress) < 1) {
    $boolAddress = 0;
}
//user address info
$objUserAddressInfo = '';
if ($_GET['AddId'] != null) {
    $AddressIdKey = $_GET['AddId'];
    $SCondition = " Enabled = '$Enabled' and UserIdKey = '$UserIdKey' and IdKey = '$AddressIdKey' ";
    $objUserAddressInfo = $objORM->Fetch($SCondition, 'NicName,Address,IdKey', TableIWUserAddress);

}
$boolGotoBank = 1;
if (!isset($_GET['AddId']) or $_GET['AddId'] == null or $objUserAddressInfo->IdKey == null or $objORM->DataCount($SCondition, TableIWUserAddress) < 1) {
    $boolGotoBank = 0;
}


$strProductsFactor = '';
$intTotalPrice = 0;
$intTotalShipping = 0;

$arrAddToCart = '';

// url
$ActualPageLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$SCondition = "  ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' )  and ProductId != ''  ";
$objUserTempCart = $objORM->FetchAll($SCondition, '*', TableIWUserTempCart);

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

    $strOtherData = $objGlobalVar->JsonDecodeArray($objGlobalVar->deBase64($ListItem->ApiContent));

    if (!$strOtherData['isInStock']) {
        $objORM->DataUpdate($SCondition, " Enabled = $Disabled", TableIWAPIProducts);
        $objORM->DeleteRow(" ProductId = '$UserTempCart->ProductId' and ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' )  ", TableIWUserTempCart);
        continue;
    }

    //Size
    $strSize = '';
    $arrSize = array();
    foreach ($strOtherData['variants'] as $Size) {
        $arrSize[] = $Size['brandSize'];
    }
    foreach (array_unique($arrSize) as $Size) {

        $strSelected = '';
        if ($strSizeSelect == $Size)
            $strSelected = 'selected';

        $strSize .= '<option ' . $strSelected . '  value="' . $Size . '">' . $Size . '</option>';
    }

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


    $strProductsFactor .= '<tr>';
    $strProductsFactor .= '<td class="product-name">';
    $strProductsFactor .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsFactor .= $ListItem->Name;
    $strProductsFactor .= '</a></td>';
    $strProductsFactor .= '<td class="product-total" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactor .= '<span class="subtotal-amount">' . $UserTempCart->Size . '</span>';
    $strProductsFactor .= '</td>';
    $strProductsFactor .= '<td class="product-total" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactor .= '<span class="subtotal-amount" >' . $intCountSelect . '</span>';
    $strProductsFactor .= '</td>';
    $strProductsFactor .= '<td class="product-total" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactor .= '<span class="subtotal-amount">' . $strPricingPartTotal . '</span>';
    $strProductsFactor .= '</td></tr>';


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

    $strProductsFactorFull .= '<tr>';
    $strProductsFactorFull .= '<td class="product-name">';
    $strProductsFactorFull .= $ListItem->Name;
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-name">';
    $strProductsFactorFull .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 120, 'class="main-image"');
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-total">';
    $strProductsFactorFull .= '<span class="subtotal-amount">' . $strSize . '</span>';
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-total">';
    $strProductsFactorFull .= '<span class="subtotal-amount">' . $UserTempCart->ProductId . '</span>';
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-total" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactorFull .= '<span class="subtotal-amount">' . $intCountSelect . '</span>';
    $strProductsFactorFull .= '</td>';
    $strProductsFactorFull .= '<td class="product-total" style="margin:5px; padding:5px; text-align: center; ">';
    $strProductsFactorFull .= '<span class="subtotal-amount">' . $strPricingPartTotal . '</span>';
    $strProductsFactorFull .= '</td></tr>';


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

