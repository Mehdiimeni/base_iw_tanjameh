<?php
//MainBasketModify.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

$objTimeTools = new TimeTools();
$ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
$ModifyTime = $objTimeTools->jdate("H:i:s");
$ModifyDate = $objTimeTools->jdate("Y/m/d");


if (@$objGlobalVar->RefFormGet()[0] != null) {
    $BasketIdKey = $objGlobalVar->RefFormGet()[0];


    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');


    $strProductsFactor = '';
    $intTotalPrice = 0;
    $intTotalShipping = 0;

    $arrAddToCart = '';


    $SCondition = "  ( BasketIdKey = '$BasketIdKey'  )   ";
    $objUserMainCart = $objORM->FetchAll($SCondition, '*', TableIWAUserMainCart);

    $arrAllProductW = array();
    $intPackcount = 0;
    foreach ($objUserMainCart as $UserMainCart) {
        $strPricingPart = '';
        $strSizeSelect = '';
        $intCountSelect = 1;


        $strSizeSelect = $UserMainCart->Size;
        $UserMainCart->Count != '' ? $intCountSelect = $UserMainCart->Count : $intCountSelect = 1;
        $SCondition = "Enabled = '$Enabled' AND  ProductId = '$UserMainCart->ProductId' ";

        $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

        $strExistence = FA_LC["available"];

        $strOtherData = $objGlobalVar->JsonDecodeArray($objGlobalVar->deBase64($ListItem->ApiContent));

        if (!$strOtherData['isInStock']) {
            $objORM->DataUpdate($SCondition, " Enabled = $Disabled", TableIWAPIProducts);
            $objORM->DeleteRow(" ProductId = '$UserMainCart->ProductId' and ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' )  ", TableIWUserMainCart);
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

        $SCondition = "IdKey = '$ListItem->WeightIdKey'";
        $WeightNumber = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;

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


        $strProductsFactor .= '<tr>';
        $strProductsFactor .= '<td class="product-name">';
        $strProductsFactor .= '<a target="_blank" href="https://www.asos.com/' .$ListItem->Url . '">';
        $strProductsFactor .= $ListItem->Name;
        $strProductsFactor .= '</a></td>';
        $strProductsFactor .= '<td class="product-total">';
        $strProductsFactor .= '<span class="subtotal-amount">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 120, 'class="main-image"')
        . '</span>';
        $strProductsFactor .= '</td>';
        $strProductsFactor .= '<td class="product-total">';
        $strProductsFactor .= '<span class="subtotal-amount">' . $UserMainCart->Size . '</span>';
        $strProductsFactor .= '</td>';
        $strProductsFactor .= '<td class="product-total">';
        $strProductsFactor .= '<span class="subtotal-amount">' . $UserMainCart->Count . '</span>';
        $strProductsFactor .= '</td>';
        $strProductsFactor .= '<td class="product-total">';
        $strProductsFactor .= '<span class="subtotal-amount">' . $strPricingPartTotal . '</span>';
        $strProductsFactor .= '</td>';
        $strProductsFactor .= '</tr>';


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
}