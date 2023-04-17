<?php
//PopularProducts.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$objGlobalVar = new GlobalVarTools();

$Enabled = BoolEnum::BOOL_TRUE();

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');


$strPopular = '';
$SCondition = "Enabled = '$Enabled' And AdminOk = 1 AND Content IS NOT NULL  ";
if(@$_GET['Gender'] != '') {
    $PGender = $_GET['Gender'];
    $SCondition .= "  AND  PGender = '$PGender'  ";
}

if(@$_GET['Category '] != '') {
    $PCategory = $_GET['Category '];
    $SCondition .= " AND  PCategory = '$PCategory'  ";
}

if(@$_GET['Group'] != '') {
    $PGroup= $_GET['Group'];
    $SCondition .= " AND  PGroup = '$PGroup'  ";
}

foreach ($objORM->FetchLimit($SCondition, 'ProductId,PGender,PCategory,ImageSet,PGroup,PGroup2,Name,Content,IdKey,CatId', 'RAND(), PView DESC', 6, TableIWAPIProducts) as $ListItem) {

    $strPricingPart = '';
    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
    $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
    $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
    $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
    $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;

    $boolChange = 0;

    if($CarentCurrencyPrice != $PreviousCurrencyPrice and $PreviousCurrencyPrice!= 0)
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

    $strPopular .= '<div class="col-lg-4 col-md-6 col-sm-6"><div class="single-products-box"><div class="products-image">';
    $strPopular .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey  . '">';
    $strPopular .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 670, 'class="main-image"');
    $strPopular .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[1], $ListItem->Name, 670, 'class="hover-image"');
    $strPopular .= '</a><div class="products-button"><ul><li><div class="wishlist-btn">';
    $strPopular .= '<a href="#" data-wishlist="' . $ListItem->ProductId . '">';
    $strPopular .= '<i class="bx bx-heart"></i><span class="tooltip-label">' . FA_LC["add"] . ' ' . FA_LC['list_wishlist'] . '</span></a></div></li>';
    $strPopular .= '<li><div class="compare-btn">';
    $strPopular .= '<a href="#" data-comparison="' . $ListItem->ProductId . '">';
    $strPopular .= '<i class="bx bx-refresh"></i><span class="tooltip-label">' . FA_LC['comparison'] . '</span></a></div></li>';
    $strPopular .= '</ul></div></div>';
    $strPopular .= '<div class="products-content">';
    $strPopular .= '<h3><a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey  . '">'.$ListItem->Name.'</a></h3>';
    $strPopular .= '<div class="price">' . $strPricingPart . '</div>';
    $strPopular .= '<a href="#"   data-basket="' . $ListItem->ProductId . '" class="add-to-cart">' . FA_LC['add_to_cart'] . '</a>';
    $strPopular .= '</div></div></div>';
}

include "./view/Adver/PopularProducts.php";