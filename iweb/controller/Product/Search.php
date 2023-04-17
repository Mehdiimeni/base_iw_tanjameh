<?php
//Search.php


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


if (isset($_POST['SubmitSearch']) and @$_POST['Search'] != '') {

    $strSearch = @$_POST['Search'];
    $SCondition = " (AdminOk =1 and Enabled =1 and Content IS NOT NULL and CatId IS NOT NULL) and 
                   (ProductId LIKE '%$strSearch%' OR 
                   IdKey LIKE '%$strSearch%' OR 
                   Name regexp '$strSearch' OR 
                   LocalName regexp '$strSearch' OR 
                   ProductCode LIKE '%$strSearch%' OR 
                   ProductId LIKE '%$strSearch%' OR 
                   PGender regexp '$strSearch' OR 
                   PCategory regexp '$strSearch' OR 
                   PGroup regexp '$strSearch' OR
                   PGroup2 regexp '$strSearch' OR 
                   BrandName regexp '$strSearch' OR 
                   Size regexp '$strSearch' OR 
                   Color regexp '$strSearch' OR 
                   ProductType regexp '$strSearch'
                   ) ";

// make url
    $ActualPageLink = '?ln=&ProductList=1&Gender=' . $_GET['Gender'] . '&Category=' . $_GET['Category'] . '&Group=' . $_GET['Group'] . '&CatId=' . $_GET['CatId'];

    if ($_GET['Size'] != '')
        $ActualPageLink .= '&Size=' . $_GET['Size'];
    if ($_GET['Type'] != '')
        $ActualPageLink .= '&Type=' . $_GET['Type'];
    if ($_GET['Color'] != '')
        $ActualPageLink .= '&Color=' . $_GET['Color'];
    if ($_GET['Brand'] != '')
        $ActualPageLink .= '&Brand=' . $_GET['Brand'];
    if ($_GET['Brand'] != '')
        $ActualPageLink .= '&Brand=' . $_GET['Brand'];
    if ($_GET['Sort'] != '')
        $ActualPageLink .= '&Sort=' . $_GET['Sort'];
    if ($_GET['pagein'] != '')
        $ActualPageLink .= '&pagein=' . $_GET['pagein'];


    $strFilter = "ModifyDate DESC";

    if (isset($_GET['Sort'])) {

        if ($_GET['Sort'] == 'popular')
            $strFilter = "PView DESC";

        if ($_GET['Sort'] == 'sale')
            $strFilter = "PBuy DESC";

        if ($_GET['Sort'] == 'lowprice')
            $strFilter = "MainPrice ASC";

        if ($_GET['Sort'] == 'latest')
            $strFilter = "ModifyDate DESC";

        if ($_GET['Sort'] == 'highprice')
            $strFilter = "MainPrice DESC";

    }


    if (isset($_GET['Size'])) {
        $Size = $_GET['Size'];
        $SCondition .= " AND Size REGEXP '$Size' ";
    }

    if (isset($_GET['Type'])) {
        $Type = $_GET['Type'];
        $SCondition .= " AND ProductType REGEXP '$Type' ";
    }

    if (isset($_GET['Color'])) {
        $Color = $_GET['Color'];
        $SCondition .= " AND Color = '$Color' ";
    }

    if (isset($_GET['Brand'])) {
        $BrandName = $_GET['Brand'];
        $SCondition .= " AND BrandName = '$BrandName' ";
    }


// Filter Brands

    $strFilterBrands = '';
    $SConditionFilterBrand = '';
    $SConditionFilterBrand .= $SCondition . " and BrandName != '' GROUP BY BrandName ";
    foreach ($objORM->FetchAll($SConditionFilterBrand, 'BrandName,CatId', TableIWAPIProducts) as $ListItem) {

        $strFilterBrands .= '<li class="widget-list-item widget-filter-item">';
        $strFilterBrands .= '<a class="widget-list-link d-flex justify-content-between align-items-center" href="' . $ActualPageLink . '&Brand=' . $ListItem->BrandName . '">';
        $strFilterBrands .= '<span class="widget-filter-item-text">' . $ListItem->BrandName . '</span></a></li>';

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

        $strFilterColors .= '<li class="widget-list-item widget-filter-item">';
        $strFilterColors .= '<a class="widget-list-link d-flex justify-content-between align-items-center" href="' . $ActualPageLink . '&Color=' . $AllColor . '">';
        $strFilterColors .= '<span class="widget-filter-item-text">' . $AllColor . '</span></a></li>';

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

        $strFilterSize .= '<li class="widget-list-item widget-filter-item">';
        $strFilterSize .= '<a class="widget-list-link d-flex justify-content-between align-items-center" href="' . $ActualPageLink . '&Size=' . $AllSize . '">';
        $strFilterSize .= '<span class="widget-filter-item-text">' . $AllSize . '</span></a></li>';

    }


// Filter Sort
    $strFilterSort = '';

    $arrAllSort = array( 'popular'=>FA_LC['popular'], 'sale'=>FA_LC['sale'], 'lowprice'=>FA_LC['low_price'], 'latest'=>FA_LC['latest'], 'highprice'=>FA_LC['high_price']);
    foreach ($arrAllSort as $SortKey => $SortValue) {

        $strFilterSort .= '<li class="widget-list-item widget-filter-item">';
        $strFilterSort .= '<a class="widget-list-link d-flex justify-content-between align-items-center" href="' . $ActualPageLink . '&Sort=' . $SortKey . '">';
        $strFilterSort .= '<span class="widget-filter-item-text">' . $SortValue . '</span></a></li>';

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

        $strFilterType .= '<li class="widget-list-item widget-filter-item">';
        $strFilterType .= '<a class="widget-list-link d-flex justify-content-between align-items-center" href="' . $ActualPageLink . '&Type=' . $AllType . '">';
        $strFilterType .= '<span class="widget-filter-item-text">' . $AllType . '</span></a></li>';

    }


// Filter Selection

    $strFilterSelection = '<li><a href="#"><i class="bx bx-x"></i></a></li>';


// paging
    $intCountAllProducts = $objORM->DataCount($SCondition, TableIWAPIProducts);
    $perPage = 28;
    $page = (isset($_GET['pagein'])) ? (int)$_GET['pagein'] : 1;
    $startAt = $perPage * ($page - 1);


    $totalPages = ceil($intCountAllProducts / $perPage);

    $links = "";
    $strPaging = "";
    for ($i = 1; $i <= $totalPages; $i++) {

        $strCurrent = "";

        @(int)$_GET['pagein'] == $i ? $strCurrent = 'aria-current="page"' : $strCurrent = "";


        $strPaging .= ($i != $page)
            ? "<li class='page-item d-none d-sm-block'><a class='page-link' href='$ActualPageLink&pagein=$i'  $strCurrent > $i</a></li>"
            : "<li class='page-item active d-none d-sm-block' aria-current='page'><span class='page-link'>$page</span></li>";
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

        $MainCategorySelected .= '<div class="col-lg-3 col-md-4 col-sm-6 products-col-item">';
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

} else {
    $intCountAllProducts = 0;
    $strSearch = FA_LC["not_find"];
}

