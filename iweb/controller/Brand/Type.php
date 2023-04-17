<?php
//Type.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$ApiReplacePeriod = 2;
$ApiGetLive = 0;

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$strAllType = '';
$SCondition = " Enabled = $Enabled AND ProductType IS NOT NULL  GROUP BY ProductType ORDER BY ProductType ASC ";
$CounterSet = 0;
$intLiCounter = 1;
foreach ($objORM->FetchAll($SCondition, 'ProductType', TableIWAPIProducts) as $ListItem) {

    $strNameProductType = $ListItem->ProductType;
    $strProductTypeUrl = $objGlobalVar->getUrlDecode($ListItem->ProductType);

    if ($strNameProductType == '')
        continue;


    if ($CounterSet % 7 == 0) {
        $strAllType .= '<div class="col-lg-3 col-md-6 col-sm-6">';
        $strAllType .= '<div class="about-text" >';
        $strAllType .= '<ul class="features-list" >';

        $intLiCounter = 1;
    }
    $strAllType .= "<li><i class='bx bx-check'></i><a href='?part=Product&page=Type&ProductType=" . $strProductTypeUrl . "' title='" . $strNameProductType . "'> " . $strNameProductType . "</a></li>";

    if ($intLiCounter == 7) {
        $strAllType .= ' </ul > ';
        $strAllType .= '</div > ';
        $strAllType .= '</div > ';
    }
    $intLiCounter++;
    $CounterSet++;


}





