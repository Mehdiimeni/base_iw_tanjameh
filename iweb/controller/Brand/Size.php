<?php
//Size.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();
$ApiReplacePeriod = 2;
$ApiGetLive = 0;

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$strAllSize = '';
$SCondition = " Enabled = $Enabled AND Size IS NOT NULL OR Size != ''  GROUP BY Size ORDER BY Size ASC ";
$CounterSet = 0;
$intLiCounter = 1;
$arrAllSize = array();
foreach ($objORM->FetchAll($SCondition, 'Size', TableIWAPIProducts) as $ListItem) {


    $arrAllSize = array_merge($arrAllSize, explode(",", $ListItem->Size));

}
$arrAllSize = array_unique($arrAllSize);
foreach ($arrAllSize as $AllSize) {


    if ($AllSize == '')
        continue;


    if ($CounterSet % 7 == 0) {
        $strAllSize .= '<div class="col-lg-3 col-md-6 col-sm-6">';
        $strAllSize .= '<div class="about-text" >';
        $strAllSize .= '<ul class="features-list" >';

        $intLiCounter = 1;
    }
    $strAllSize .= "<li><i class='bx bx-check'></i><a href='?part=Product&page=Size&Size=" . $objGlobalVar->getUrlDecode($AllSize ). "' title='" . $AllSize . "'> " . $AllSize . "</a></li>";

    if ($intLiCounter == 7) {
        $strAllSize .= ' </ul > ';
        $strAllSize .= '</div > ';
        $strAllSize .= '</div > ';
    }
    $intLiCounter++;
    $CounterSet++;


}





