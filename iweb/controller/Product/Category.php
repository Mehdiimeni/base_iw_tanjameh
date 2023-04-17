<?php
//Category.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$ApiReplacePeriod = 2;
$ApiGetLive = 0;

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$MainCategorySelected = '';

$PGenderId = '';


// filter

$strClear = '';
$SCondition = "Enabled = '$Enabled' AND Content IS NOT NULL And AdminOk = 1";

if (isset($_GET['CatId'])) {
    $CatId = $_GET['CatId'];
    $SCondition .= " AND CatId = '$CatId' ";
    $strClear .= '&CatId=' . $_GET['CatId'];
}
/* if (@$_GET['Gender'] != '') {
     $PGender = strtolower($objGlobalVar->getUrlEncode($_GET['Gender']));
     $SCondition .= "  AND  PGender = '$PGender'  ";
     $strClear .= '?Gender=' . $_GET['Gender'];
 }

 if (@$_GET['Category'] != '') {
     $PCategory = strtolower($objGlobalVar->getUrlEncode($_GET['Category']));
     $SCondition .= " AND  PCategory = '$PCategory'  ";
     $strClear .= '&Category=' . $_GET['Category'];
 }

 if (@$_GET['Group'] != '') {
     $PGroup = strtolower($objGlobalVar->getUrlEncode($_GET['Group']));
     $SCondition .= " AND  PGroup = '$PGroup'  ";
     $strClear .= '&Group=' . $_GET['Group'];
 }
*/

$strFilter = "ModifyDate DESC";

if (isset($_GET['filter'])) {

    if ($_GET['filter'] == 'popular')
        $strFilter = "PView DESC";

    if ($_GET['filter'] == 'sale')
        $strFilter = "PBuy DESC";

    if ($_GET['filter'] == 'lowprice')
        $strFilter = "MainPrice ASC";

    if ($_GET['filter'] == 'latest')
        $strFilter = "ModifyDate DESC";

    if ($_GET['filter'] == 'highprice')
        $strFilter = "MainPrice DESC";

}


if (isset($_GET['Size'])) {
    $Size = $_GET['Size'];
    $SCondition .= " AND Size REGEXP '$Size' ";
}

if (isset($_GET['Color'])) {
    $Color = $_GET['Color'];
    $SCondition .= " AND Color = '$Color' ";
}

if (isset($_GET['BrandName'])) {
    $BrandName = $_GET['BrandName'];
    $SCondition .= " AND BrandName = '$BrandName' ";
}

// url
$ActualPageLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// Filtering

// Filter Brands

$strFilterBrands = '';
$SConditionFilterBrand = '';
$SConditionFilterBrand .= $SCondition . " and BrandName != '' GROUP BY BrandName ";
foreach ($objORM->FetchAll($SConditionFilterBrand, 'BrandName,CatId', TableIWAPIProducts) as $ListItem) {

    $strFilterBrands .= '<div class="list-group-item checkbox"><label>';
    $strFilterBrands .= '<input type="checkbox" class="filter_all brand" value="' . $ListItem->BrandName . '">' . $ListItem->BrandName;
    $strFilterBrands .= '</label></div>';

}

// Filter Color
$strFilterColors = '';
$SConditionFilterColors = '';
$arrAllColor = array();
$SConditionFilterColors .= $SCondition . " and Color != '' GROUP BY Color ";
foreach ($objORM->FetchAll($SConditionFilterColors, 'Color,CatId', TableIWAPIProducts) as $ListItem) {

    $arrAllColor[] = $ListItem->Color;

}
$arrAllColor = array_unique($arrAllColor);

foreach ($arrAllColor as $AllColor) {
    $strFilterColors .= '<div class="list-group-item checkbox"><label>';
    $strFilterColors .= ' <input type="checkbox" class="filter_all color color-' . strtolower(str_replace(" ", "-", trim($AllColor))) . '" value="' . $AllColor . '">' . $AllColor;
    $strFilterColors .= '</label></div>';
}

// Filter Size
$strFilterSize = '';
$SConditionFilterSize = '';
$arrAllSize = array();
$SConditionFilterSize .= $SCondition . " and Size != '' GROUP BY Size ";
foreach ($objORM->FetchAll($SConditionFilterSize, 'Size,CatId', TableIWAPIProducts) as $ListItem) {
    $arrAllSize = array_merge($arrAllSize, explode(",", $ListItem->Size));

}
$arrAllSize = array_unique($arrAllSize);
foreach ($arrAllSize as $AllSize) {

    $strFilterSize .= '<div class="list-group-item checkbox"><label>';
    $strFilterSize .= ' <input type="checkbox" class="filter_all size" value="' . $AllSize . '">' . $AllSize;
    $strFilterSize .= '</label></div>';

}


// Filter Type
$strFilterType = '';
$SConditionFilterType = '';
$arrAllType = array();
$SConditionFilterType .= $SCondition . " and ProductType != '' GROUP BY ProductType ";
foreach ($objORM->FetchAll($SConditionFilterType, 'ProductType,CatId', TableIWAPIProducts) as $ListItem) {
    $arrAllType = array_merge($arrAllType, explode(",", $ListItem->ProductType));

}
$arrAllType = array_unique($arrAllType);
foreach ($arrAllType as $AllType) {

    $strFilterType .= '<div class="list-group-item checkbox"><label>';
    $strFilterType .= ' <input type="checkbox" class="filter_all type" value="' . $AllType . '">' . $AllType;
    $strFilterType .= '</label></div>';

}


// Filter Selection

$strFilterSelection = '<li><a href="#"><i class="bx bx-x"></i></a></li>';


// paging
$intCountAllProducts = $objORM->DataCount($SCondition, TableIWAPIProducts);
$perPage = 18;
$page = (isset($_GET['pagein'])) ? (int)$_GET['pagein'] : 1;
$startAt = $perPage * ($page - 1);


$totalPages = ceil($intCountAllProducts / $perPage);

$links = "";
$strPaging = "";
for ($i = 1; $i <= $totalPages; $i++) {

    $strCurrent = "";

    @(int)$_GET['pagein'] == $i ? $strCurrent = 'aria-current="page"' : $strCurrent = "";


    $strPaging .= ($i != $page)
        ? "<a href='$ActualPageLink&pagein=$i'  $strCurrent class='page-numbers'> $i</a> "
        : "$page ";
}

$strLimit = $startAt . ',' . $perPage;


foreach ($objORM->FetchLimit($SCondition, 'IdKey,Name,ProductId,ImageSet,Content,PGender,PCategory,PGroup,CatId', $strFilter, $strLimit, TableIWAPIProducts) as $ListItem) {

    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
    $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
    $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
    if ($CarentCurrencyPrice != null) {
        $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
        $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
    }


    $objArrayImage = explode("==::==", $ListItem->Content);
    $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

    $intImageCounter = 1;
    foreach ($objArrayImage as $image) {
        if (@strpos($ListItem->ImageSet, (string)$intImageCounter) === false) {

            unset($objArrayImage[$intImageCounter]);
        }
        $intImageCounter++;
    }
    $objArrayImage = array_values($objArrayImage);


    $strMainImage = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->ProductId, 314, 'class="main-image"');
    $strHoverImage = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[1], $ListItem->ProductId, 314, 'class="hover-image"');

    if (str_contains($strMainImage, 'no-image')) {

        $DCondition = "IdKey = '$ListItem->IdKey' ";
        // $objORM->DeleteRow($DCondition, TableIWAPIProducts);
        continue;
    }


    $MainCategorySelected .= '<div class="col-lg-6 col-md-6 col-sm-6 products-col-item">';
    $MainCategorySelected .= '<div class="single-productsBox">';
    $MainCategorySelected .= '<div class="products-image">';
    $MainCategorySelected .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $MainCategorySelected .= $strMainImage;
    $MainCategorySelected .= $strHoverImage;
    $MainCategorySelected .= '</a>';
    $MainCategorySelected .= '<div class="products-button">';
    $MainCategorySelected .= '<ul>';
    $MainCategorySelected .= '<li>';
    $MainCategorySelected .= '<div class="wishlist-btn">';
    $MainCategorySelected .= '<a href="#" data-wishlist="' . $ListItem->ProductId . '">';
    $MainCategorySelected .= '<i class="bx bx-heart"></i>';
    $MainCategorySelected .= '<span class="tooltip-label">' . FA_LC["add_to_wishlist"] . '</span>';
    $MainCategorySelected .= '</a>';
    $MainCategorySelected .= '</div>';
    $MainCategorySelected .= '</li>';
    $MainCategorySelected .= '<li>';
    $MainCategorySelected .= '<div class="compare-btn">';
    $MainCategorySelected .= '<a href="#" data-comparison="' . $ListItem->ProductId . '">';
    $MainCategorySelected .= '<i class="bx bx-refresh"></i>';
    $MainCategorySelected .= '<span class="tooltip-label">' . FA_LC["comparison"] . '</span>';
    $MainCategorySelected .= '</a>';
    $MainCategorySelected .= '</div>';
    $MainCategorySelected .= '</li>';
    $MainCategorySelected .= '</ul>';
    $MainCategorySelected .= '</div>';
    $MainCategorySelected .= '</div>';
    $MainCategorySelected .= '<div class="products-content">';
    $MainCategorySelected .= '<span class="category">' . $ListItem->PGroup . '</span>';
    $MainCategorySelected .= '<h3>';
    $MainCategorySelected .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $MainCategorySelected .= $ListItem->Name . '</a></h3>';
    $MainCategorySelected .= '<div class="price">';
    $MainCategorySelected .= '<span class="new-price">' . $CarentCurrencyPrice . '</span>';
    $MainCategorySelected .= '</div>';
    $MainCategorySelected .= '<a href="#"  class="add-to-cart" data-basket="' . $ListItem->ProductId . '">';
    $MainCategorySelected .= FA_LC["add_to_cart"] . '</a>';
    $MainCategorySelected .= '</div>';
    $MainCategorySelected .= '</div>';
    $MainCategorySelected .= '</div>';


}

