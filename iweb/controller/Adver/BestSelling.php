<?php
//BestSelling.php
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$objGlobalVar = new GlobalVarTools();

$Enabled = BoolEnum::BOOL_TRUE();

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');


$strBestSelling = '';
$SCondition = "Enabled = '$Enabled' AND Content IS NOT NULL And AdminOk = 1";
if (@$_GET['Gender'] != '') {
    $PGender = $_GET['Gender'];
    $SCondition .= "  AND  PGender = '$PGender'  ";
}

if (@$_GET['Category '] != '') {
    $PCategory = $_GET['Category '];
    $SCondition .= " AND  PCategory = '$PCategory'  ";
}

if (@$_GET['Group'] != '') {
    $PGroup = $_GET['Group'];
    $SCondition .= " AND  PGroup = '$PGroup'  ";
}

foreach ($objORM->FetchLimit($SCondition, 'ProductId,PGender,PCategory,PGroup,PGroup2,ImageSet,Name,Content,IdKey,CatId', 'RAND(),PBuy DESC', 6, TableIWAPIProducts) as $ListItem) {

    $strPricingPart = '';
    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
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

    $strBestSelling .= '<div class="col-lg-4 col-md-6 col-sm-6"><div class="single-products-box"><div class="products-image">';
    $strBestSelling .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strBestSelling .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 670, 'class="main-image"');
    $strBestSelling .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[1], $ListItem->Name, 670, 'class="hover-image"');
    $strBestSelling .= '</a><div class="products-button"><ul><li><div class="wishlist-btn">';
    $strBestSelling .= '<a href="#" data-wishlist="' . $ListItem->ProductId . '">';
    $strBestSelling .= '<i class="bx bx-heart"></i><span class="tooltip-label">' . FA_LC["add"] . ' ' . FA_LC['list_wishlist'] . '</span></a></div></li>';
    $strBestSelling .= '<li><div class="compare-btn">';
    $strBestSelling .= '<a href="#" data-comparison="' . $ListItem->ProductId . '">';
    $strBestSelling .= '<i class="bx bx-refresh"></i><span class="tooltip-label">' . FA_LC['comparison'] . '</span></a></div></li>';
    $strBestSelling .= '</ul></div></div>';
    $strBestSelling .= '<div class="products-content"  >';
    $strBestSelling .= '<h3><a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">' . $ListItem->Name . '</a></h3>';
    $strBestSelling .= '<div class="price">' . $strPricingPart . '</div>';
    $strBestSelling .= '<a href="#" id="ShowAddToCart"  data-basket="' . $ListItem->ProductId . '" class="add-to-cart">' . FA_LC['add_to_cart'] . '</a>';
    $strBestSelling .= '</div></div></div>';
}

include "./view/Adver/BestSelling.php";
