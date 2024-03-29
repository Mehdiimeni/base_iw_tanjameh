<?php
//Partner.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

//
$SCondition = " Enabled = $Enabled and GroupIdKey = '40445154'";
$strLogoPartner = '';
if ($objORM->DataExist($SCondition, TableIWCompany)) {
    foreach ($objORM->FetchAll($SCondition, 'Name,Image,LinkTo,Icon,Line1', TableIWCompany) as $ListItem) {

        if ($ListItem->Image != null)
            $strImagePartner = $objShowFile->ShowImage('', $objShowFile->FileLocation("logo"), $ListItem->Image, $ListItem->Name, 90, '');
        $strLogoPartner .= '<div class="partner-item">';
        $strLogoPartner .= '<a href="#">' . $strImagePartner . '</a>';
        $strLogoPartner .= '</div>';


    }
    include "./view/Adver/Partner.php";
}
