<?php
//Size.php


require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$ApiReplacePeriod = 2;
$ApiGetLive = 0;

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$MainCategorySelected = '';

if (isset($_GET['Size'])) {


    $Size = $objGlobalVar->getUrlEncode($_GET['Size']);
    $SCondition = " (Enabled = $Enabled AND Content IS NOT NULL And AdminOk = 1  ) and (  Size LIKE '%$Size%') ";
    $strFilter = "last_modify DESC";

    if (isset($_GET['filter'])) {

        if ($_GET['filter'] == 'popular')
            $strFilter = "PView DESC";

        if ($_GET['filter'] == 'sale')
            $strFilter = "PBuy DESC";

        if ($_GET['filter'] == 'lowprice')
            $strFilter = "MainPrice ASC";

        if ($_GET['filter'] == 'latest')
            $strFilter = "last_modify DESC";

        if ($_GET['filter'] == 'highprice')
            $strFilter = "MainPrice DESC";

    }

    if (isset($_GET['Size'])) {
        $Size = $objGlobalVar->getUrlEncode($_GET['Size']);
        $SCondition .= " AND Size LIKE '%$Size%' ";
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

    $strClear = '?part=Product&page=Type&Size=' . $Size;

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
        $strFilterColors .= '<li><a href="' . $ActualPageLink . '&Color=' . $AllColor . '" title="' . $AllColor . '" class="color-' . strtolower(str_replace(" ", "-", trim($AllColor))) . '"></a></li>';

    }


    // Filter Type
    $strFilterType = '';
    $SConditionFilterType = '';
    $arrAllType = array();
    $SConditionFilterType .= $SCondition . " and ProductType != '' GROUP BY ProductType ";
    foreach ($objORM->FetchAll($SConditionFilterType, 'ProductType,CatId', TableIWAPIProducts) as $ListItem) {
        $arrAllType[] = $ListItem->ProductType;

    }
    $arrAllType = array_unique($arrAllType);
    foreach ($arrAllType as $AllType) {
        $strFilterType .= '<li><a href="' . $ActualPageLink . '&Type=' . $objGlobalVar->getUrlDecode($AllType). '" title="' . $AllType . '" >' . $AllType . '</a></li>';

    }

    // Filter Brands

    $strFilterBrands = '';
    $SConditionFilterBrand = '';
    $SConditionFilterBrand .= $SCondition . " and BrandName != '' GROUP BY BrandName ";
    foreach ($objORM->FetchAll($SConditionFilterBrand, 'BrandName,CatId', TableIWAPIProducts) as $ListItem) {

        $strFilterBrands .= '<li><a href="' . $ActualPageLink . '&BrandName=' . $ListItem->BrandName . '">' . $ListItem->BrandName . '</a></li>';

    }


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

        $SArgument = "'$ListItem->id','c72cc40d','fea9f1bf'";
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

        $MainCategorySelected .= '<div class="col-lg-6 col-md-6 col-sm-6 products-col-item">';
        $MainCategorySelected .= '<div class="single-productsBox">';
        $MainCategorySelected .= '<div class="products-image">';
        $MainCategorySelected .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->id . '">';
        $MainCategorySelected .= $strMainImage;
        $MainCategorySelected .= $strHoverImage;
        $MainCategorySelected .= '</a>';
        $MainCategorySelected .= '<div class="products-button">';
        $MainCategorySelected .= '<ul>';
        $MainCategorySelected .= '<li>';
        $MainCategorySelected .= '<div class="wishlist-btn">';
        $MainCategorySelected .= '<a href="#" data-wishlist="' . $ListItem->ProductId . '">';
        $MainCategorySelected .= '<i class="bx bx - heart"></i>';
        $MainCategorySelected .= '<span class="tooltip-label">' . FA_LC["add_to_wishlist"] . '</span>';
        $MainCategorySelected .= '</a>';
        $MainCategorySelected .= '</div>';
        $MainCategorySelected .= '</li>';
        $MainCategorySelected .= '<li>';
        $MainCategorySelected .= '<div class="compare-btn">';
        $MainCategorySelected .= '<a href="#" data-comparison="' . $ListItem->ProductId . '">';
        $MainCategorySelected .= '<i class="bx bx - refresh"></i>';
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
        $MainCategorySelected .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->id . '">';
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


}





