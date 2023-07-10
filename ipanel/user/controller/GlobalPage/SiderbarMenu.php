<?php
//SiderbarMenu.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";

$Enabled = true;

$SCondition = " Enabled = $Enabled ORDER BY id ";

$strMenu = '';
$strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
$objGlobalVar->setGetVarNull();
$arrLinkMenu = array('ln' => @$strGlobalVarLanguage, 'part' => '', 'page' => '');
foreach ($objORM->FetchAll($SCondition, 'PartName,id,Name,FaIcon', TableIWPanelUserPart) as $ListItem) {

    if (!array_key_exists($ListItem->id, $arrAccess))
        continue;

    $arrLinkMenu['part'] = $ListItem->Name;
    $strMenu .= '<li><a><i class="fa ' . $ListItem->FaIcon . '"></i>';
    $strMenu .= $ListItem->PartName;
    $strMenu .= '<span class="fa fa-chevron-down"></span></a>';
    $strMenu .= '<ul class="nav child_menu">';
    $SCondition = " Enabled = $Enabled AND iw_panel_user_part_id = $ListItem->id  ORDER BY id ";
    foreach ($objORM->FetchAll($SCondition, 'PageName,Name,id', TableIWPanelUserPage) as $ListItem2) {

        if (array_search($ListItem2->id, $arrAccess[$ListItem->id]) < 0)
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