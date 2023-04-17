<?php
//SiderbarMenu.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";

$Enabled = BoolEnum::BOOL_TRUE();

$SCondition = " Enabled = '$Enabled' ORDER BY IdRow ";

$strMenu = '';
$strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
$objGlobalVar->setGetVarNull();
$arrLinkMenu = array('ln' => @$strGlobalVarLanguage, 'part' => '', 'page' => '');
foreach ($objORM->FetchAll($SCondition, 'PartName,IdKey,Name,FaIcon', TableIWPanelUserPart) as $ListItem) {

    if (!array_key_exists($ListItem->IdKey, $arrAccess))
        continue;

    $arrLinkMenu['part'] = $ListItem->Name;
    $strMenu .= '<li><a><i class="fa ' . $ListItem->FaIcon . '"></i>';
    $strMenu .= $ListItem->PartName;
    $strMenu .= '<span class="fa fa-chevron-down"></span></a>';
    $strMenu .= '<ul class="nav child_menu">';
    $SCondition = " Enabled = '$Enabled' AND PartIdKey = '$ListItem->IdKey'  ORDER BY IdRow ";
    foreach ($objORM->FetchAll($SCondition, 'PageName,Name,IdKey', TableIWPanelUserPage) as $ListItem2) {

        if (array_search($ListItem2->IdKey, $arrAccess[$ListItem->IdKey]) < 0)
            continue;
        $arrLinkMenu['page'] = $ListItem2->Name;
        $strLinkMenu = '?ln=' . $arrLinkMenu['ln'] . '&part=' . $arrLinkMenu['part'] . '&page=' . $arrLinkMenu['page'];
        $strMenu .= '<li><a href="' . $strLinkMenu . '">';
        $strMenu .= $ListItem2->PageName;
        $strMenu .= '</a></li>';

    }
    $strMenu .= '</ul>';
    $strMenu .= '</li>';

}
if ($stdProfile->ApiId != null) {
    $apiMainName = 'customer/' . (int)$stdProfile->ApiId;
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
    $strNewUser = 0;
    if ($objGlobalVar->JsonDecodeArray($objKMN->Get())['PanTrunc'] == null)
        $strNewUser = 1;
}