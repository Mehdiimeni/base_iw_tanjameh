<?php
//Offer.php
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

//
$SCondition = " Enabled = $Enabled and GroupIdKey = 'abc1cac5'";
$strCategoriesBanner = '';
if ($objORM->DataExist($SCondition, TableIWWebBanner)) {
    $objSTWebBanner = $objORM->Fetch($SCondition, 'Name,Image,LinkTo,BottomCaption,Line1,Line2,Line3', TableIWWebBanner);
    $strImageBanner = $objShowFile->FileLocation("banner") . $objSTWebBanner->Image;

    include "./view/Adver/Offer.php";
}