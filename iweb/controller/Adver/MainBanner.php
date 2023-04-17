<?php
//MainBanner
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');


$SCondition = " Enabled = $Enabled and GroupIdKey = 'dd143946' ";
$strBannerPart = '';
if ($objORM->DataExist($SCondition, TableIWWebBanner)) {
    foreach ($objORM->FetchAll($SCondition, 'Image,LinkTo,Position,BottomCaption,Line1,Line2,Line3,SelectColor', TableIWWebBanner) as $ListItem) {

        if($ListItem->SelectColor == '')
            $ListItem->SelectColor = "#000000";
        $strBannerPart .= '<div class="main-banner" style="background-image: url(\'' . $objShowFile->FileLocation("banner") . $ListItem->Image . '\')">';
        $strBannerPart .= '<div class="d-table"><div class="d-table-cell"><div class="container" >';
        $strBannerPart .= '<div class="main-banner-content text-' . $ListItem->Position . '">';
        $strBannerPart .= '<span class="sub-title" style="color:' . $ListItem->SelectColor . ' !important;">' . $ListItem->Line1 . '</span>';
        $strBannerPart .= '<h1 style="color:' . $ListItem->SelectColor . ' !important;">' . $ListItem->Line2 . '</h1>';
        $strBannerPart .= '<p style="color:' . $ListItem->SelectColor . ' !important;">' . $ListItem->Line3 . '</p>';
        $strBannerPart .= '<div class="btn-box" style="color:' . $ListItem->SelectColor . ' !important;">';
        $strBannerPart .= '<a href="' . $ListItem->LinkTo . '" class="optional-btn" style="color:' . $ListItem->SelectColor . ' !important;">' . $ListItem->BottomCaption . '</a>';
        $strBannerPart .= '</div></div></div></div></div></div>';
    }

    include "./view/Adver/MainBanner.php";

}




