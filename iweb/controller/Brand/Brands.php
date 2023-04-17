<?php
//Brands.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$ApiReplacePeriod = 2;
$ApiGetLive = 0;

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$strAllBrands = '';
$SCondition = " Enabled = $Enabled AND TypeSet = 'Brand' GROUP BY Title ORDER BY Title ASC ";
$CounterSet = 0;
$intLiCounter = 1;
foreach ($objORM->FetchAll($SCondition, 'CategoryId,Title,Sub2,Sub3', TableIWAPIAllCat) as $ListItem) {

    $strNameBrand = $ListItem->Title;
    $strBrandUrl = $objGlobalVar->getUrlDecode($ListItem->Sub2);



    if (isset($strBrandUrl) and strpos($strBrandUrl, 'brands') !== false) {
        $strBrandUrl = $ListItem->Sub3;
    }

    if ($strNameBrand == '')
        continue;


    if ($CounterSet % 7 == 0) {
        $strAllBrands .= '<div class="col-lg-3 col-md-6 col-sm-6">';
        $strAllBrands .= '<div class="about-text" >';
        $strAllBrands .= '<ul class="features-list" >';

        $intLiCounter = 1;
    }
    $strAllBrands .= "<li><i class='bx bx-check'></i><a href='?part=Product&page=Brand&CatId=".$ListItem->CategoryId."&BrandName=".$strBrandUrl."' title='" . $strNameBrand . "'> " . $strNameBrand . "</a></li>";

    if ($intLiCounter == 7) {
        $strAllBrands .= ' </ul > ';
        $strAllBrands .= '</div > ';
        $strAllBrands .= '</div > ';
    }
    $intLiCounter++;
    $CounterSet++;


}




