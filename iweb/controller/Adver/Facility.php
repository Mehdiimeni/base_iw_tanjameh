<?php
//Facility.php
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

//
$SCondition = " Enabled = $Enabled and GroupIdKey = '7206eee7'";
$strFacilityIcon = '';
if ($objORM->DataExist($SCondition, TableIWWebLogo)) {
    foreach ($objORM->FetchAll($SCondition, 'Name,Image,LinkTo,Icon,Line1', TableIWWebLogo) as $ListItem) {

        if ($ListItem->Image != null)
            $strImageBanner = $objShowFile->ShowImage('', $objShowFile->FileLocation("logo"), $ListItem->Image, $ListItem->Name, 180, '');
        $strFacilityIcon .= '<div class="single-facility-box"><div class="icon">';
        $strFacilityIcon .= '<i class="' . $ListItem->Icon . '"></i>';
        $strFacilityIcon .= '</div>';
        $strFacilityIcon .= '<h3>' . $ListItem->Line1 . '</h3>';
        $strFacilityIcon .= '</div>';


    }

    include "./view/Adver/Facility.php";
}
