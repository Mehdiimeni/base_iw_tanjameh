<?php
//CategoriesBanner.php
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

//
$SCondition = " Enabled = $Enabled and GroupIdKey = '9fda6060'";
$strCategoriesBanner = '';
if ($objORM->DataExist($SCondition, TableIWWebBanner)) {
    foreach ($objORM->FetchAll($SCondition, 'Name,Image,LinkTo,BottomCaption,Line1,Line2', TableIWWebBanner) as $ListItem) {
        $strImageBanner = $objShowFile->ShowImage('', $objShowFile->FileLocation("banner"), $ListItem->Image, $ListItem->Name, 750, '');
        $strCategoriesBanner .= '<div class="col-lg-3 col-md-6 col-sm-6"><div class="single-categories-box">';
        $strCategoriesBanner .= $strImageBanner;
        $strCategoriesBanner .= '<div class="content text-white">';
        $strCategoriesBanner .= '<span >' . $ListItem->Line1 . '</span>';
        $strCategoriesBanner .= '<h3>' . $ListItem->Line2 . '</h3>';
        $strCategoriesBanner .= '<a href="' . $ListItem->LinkTo . '" class="default-btn">' . $ListItem->BottomCaption . '</a>';
        $strCategoriesBanner .= '</div>';
        $strCategoriesBanner .= '<a href="' . $ListItem->LinkTo . '" class="link-btn"></a>';
        $strCategoriesBanner .= '</div></div>';

    }

    include "./view/Adver/CategoriesBanner.php";
}

