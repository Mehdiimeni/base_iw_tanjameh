<?php
//SiderbarMenu.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;


$iw_admin_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

$AdminGroupIdKey = $objORM->Fetch(
    "id = $iw_admin_id",
    "iw_admin_group_id",
    TableIWAdmin
)->iw_admin_group_id;

$AdminAllAccess = $objORM->Fetch(
    "iw_admin_group_id = $AdminGroupIdKey",
    'AllAccess',
    TableIWAdminAccess
)->AllAccess;

$arrAllAccess = $objGlobalVar->JsonDecodeArray($AdminAllAccess);
$strMenu = '';

foreach ($arrAllAccess as $arrPart => $arrPage) {


    $SCondition = " Enabled = $Enabled and id = $arrPart ORDER BY id ";


    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    $objGlobalVar->setGetVarNull();
    $arrLinkMenu = array('ln' => @$strGlobalVarLanguage, 'part' => '', 'page' => '');

    foreach ($objORM->FetchAll($SCondition, 'PartName,id,Name,FaIcon', TableIWPanelAdminPart) as $ListItem) {

        $arrLinkMenu['part'] = $ListItem->Name;
        $strMenu .= '<li><a><i class="fa ' . $ListItem->FaIcon . '"></i>';
        $strMenu .= $ListItem->PartName;
        $strMenu .= '<span class="fa fa-chevron-down"></span></a>';
        $strMenu .= '<ul class="nav child_menu">';
        $SCondition = " Enabled = $Enabled AND iw_panel_admin_part_id = $ListItem->id and id IN('" . implode('\',\'', $arrPage) . "')  ORDER BY id ";

        foreach ($objORM->FetchAll($SCondition, 'PageName,Name', TableIWPanelAdminPage) as $ListItem2) {

            $arrLinkMenu['page'] = $ListItem2->Name;
            $strLinkMenu = '?ln=' . $arrLinkMenu['ln'] . '&part=' . $arrLinkMenu['part'] . '&page=' . $arrLinkMenu['page'];
            $strMenu .= '<li><a href="' . $strLinkMenu . '">';
            $strMenu .= $ListItem2->PageName;
            $strMenu .= '</a></li>';

        }
        $strMenu .= '</ul>';
        $strMenu .= '</li>';

    }
}