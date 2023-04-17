<?php
//ModalParts.php

// basket preview modal
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$objGlobalVar = new GlobalVarTools();

$Enabled = BoolEnum::BOOL_TRUE();

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');


$strProductsCart = '';
$intTotalPrice = 0;

$arrAddToCart = '';

//isset($_COOKIE["addtocart"]) ? $arrAddToCart = json_decode($_COOKIE["addtocart"]) : $arrAddToCart = array();
$UserIdKey = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$UserSessionId = session_id();

$SCondition = "  ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' ) and ProductId != ''  ";
$objUserTempCart = $objORM->FetchAll($SCondition, '*', TableIWUserTempCart);
$intCountAddToCart = $objORM->DataCount($SCondition, TableIWUserTempCart);
/*
$arrAddToCart = (array)$arrAddToCart;
if (count($arrAddToCart) > 0)
    $arrAddToCart = array_filter($arrAddToCart);
*/

foreach ($objUserTempCart as $UserTempCart) {



    $strPricingPart = '';

    /*
    if ($productIdBasket == null) {
        if (($key = array_search($productIdBasket, $arrAddToCart)) !== false) {
            unset($arrAddToCart[$key]);
        }

        continue;
    }
*/

    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$UserTempCart->ProductId' ";


    $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

   /* if (!isset($ListItem->IdKey)) {
        if (($key = array_search($productIdBasket, $arrAddToCart)) !== false) {
            unset($arrAddToCart[$key]);
        }

         continue;
    }
*/


    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
    $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);

    $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
    $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;



    $intTotalPrice += $CarentCurrencyPrice;

    if ($CarentCurrencyPrice ) {
        $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
        $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);

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

    $strProductsCart .= '<div class="products-cart"><div class="products-image">';
    $strProductsCart .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsCart .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 120, 'class="main-image"');
    $strProductsCart .= '</a></div>';
    $strProductsCart .= '<div class="products-content">';
    $strProductsCart .= '<h3>';
    $strProductsCart .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsCart .= $ListItem->Name . '</a></h3>';
    $strProductsCart .= '<div class="products-price">';
    $strProductsCart .= $CarentCurrencyPrice;
    $strProductsCart .= '</div>';
    $strProductsCart .= '<a href="#" class="remove-btn" data-rebasket="' . $ListItem->ProductId . '"><i class="bx bx-trash"></i></a>';
    $strProductsCart .= '</div></div>';

}
// total
if ($intTotalPrice != 0) {
    $intTotalPrice = $objGlobalVar->NumberFormat($intTotalPrice, 0, ".", ",");
    $intTotalPrice = $objGlobalVar->Nu2FA($intTotalPrice);
}

/*
if (isset($_COOKIE["quickview"])) {
    $ProductId = $_COOKIE["quickview"];

    if ($ProductId != '') {

        $SCondition = "Enabled = '$Enabled' AND  ProductId = $ProductId ";

        $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);
        if (@$ListItem->Content != '') {
            $objArrayImage = explode('==::==', $ListItem->Content);
            @$strQuickviewImage1 = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 500, '');
            @$strQuickviewImage2 = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[1], $ListItem->Name, 500, '');
            @$strQuickviewImage3 = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[2], $ListItem->Name, 500, '');
            @$strQuickviewImage4 = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[3], $ListItem->Name, 500, '');
        }
    }
}
*/
// wishlist
$strProductsWishlist = '';
isset($_COOKIE["wishlist"]) ? $arrWishlist = json_decode($_COOKIE["wishlist"]) : $arrWishlist = array();

foreach ($arrWishlist as $productIdBasket) {
    $strPricingPart = '';
    if ($productIdBasket == null){
        if (($key = array_search($productIdBasket, $arrWishlist)) !== false) {
            unset($arrWishlist[$key]);
        }
        continue;
    }


    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$productIdBasket' ";

    $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

    if (!isset($ListItem->IdKey)) {
        if (($key = array_search($productIdBasket, $arrWishlist)) !== false) {
            unset($arrWishlist[$key]);
        }
        continue;
    }

    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
    $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);

    $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;

    if ($CarentCurrencyPrice != null) {
        $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
        $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);

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

    $strProductsWishlist .= '<div class="products-cart"><div class="products-image">';
    $strProductsWishlist .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsWishlist .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 120, 'class="main-image"');
    $strProductsWishlist .= '</a></div>';
    $strProductsWishlist .= '<div class="products-content">';
    $strProductsWishlist .= '<h3>';
    $strProductsWishlist .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsWishlist .= $ListItem->Name . '</a></h3>';
    $strProductsWishlist .= '<div class="products-price">';
    $strProductsWishlist .= $CarentCurrencyPrice;
    $strProductsWishlist .= '</div>';
    $strProductsWishlist .= '<a href="#"  data-rebasket="' . $ListItem->ProductId . '" class="remove-btn"><i class="bx bx-trash"></i></a>';
    $strProductsWishlist .= '</div></div>';




   $intCountWishlist = count($arrWishlist);

}