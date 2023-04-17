<?php
//WishList.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$objGlobalVar = new GlobalVarTools();

$Enabled = BoolEnum::BOOL_TRUE();

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$objReqular = new Regularization();
$objTimeTools = new TimeTools();

$ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
$ModifyTime = $objTimeTools->jdate("H:i:s");
$ModifyDate = $objTimeTools->jdate("Y/m/d");
$ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
$ModifyId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
$ModifyDateNow = $objGlobalVar->Nu2EN($objTimeTools->jdate("Y/m/d"));


$strProductsShop = '';
$intTotalPrice = 0;

$strProductsWishlist = '';
isset($_COOKIE["wishlist"]) ? $arrWishlist = json_decode($_COOKIE["wishlist"]) : $arrWishlist = array();
$arrWishlist = (array)$arrWishlist;
if (count($arrWishlist) > 0)
    $arrWishlist = array_filter($arrWishlist);

// url
$ActualPageLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";




foreach ($arrWishlist as $productIdBasket) {
    $strPricingPart = '';
    if ($productIdBasket == null)
        continue;

    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$productIdBasket' ";

    $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);
    if (!isset($ListItem->IdKey)) {
        continue;
    }
    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
    $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
    $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
    $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
    $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;

    $intTotalPrice += $CarentCurrencyPrice ;
    if ($CarentCurrencyPrice != null) {
        $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
        $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
        $strPricingPart = '<span class="new-price">' . $CarentCurrencyPrice . '</span>';
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
    $strProductsShop .= '</a>';
    $strProductsShop .= '</td>';
    $strProductsShop .= '<td class="product-price">';
    $strProductsShop .= '<span class="unit-amount">' . $strPricingPart . '</span>';
    $strProductsShop .= '</td>';
    $strProductsShop .= '<td class="product-subtotal">';
    $strProductsShop .= '<a href="#" data-rewishlist="' . $ListItem->ProductId . '" class="remove"><i class="bx bx-trash"></i></a>';
    $strProductsShop .= '</td></tr>';


}























