<?php
//SiderbarMenu.php

require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();


$AdminIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
$AdminGroupIdKey = $objORM->Fetch("IdKey = '$AdminIdKey'", 'GroupIdKey', TableIWAdmin)->GroupIdKey;
$AdminAllAccess = $objORM->Fetch("GroupIdKey = '$AdminGroupIdKey'", 'AllAccess', TableIWAdminAccess)->AllAccess;
$arrAllAccess = $objGlobalVar->JsonDecodeArray($AdminAllAccess);
$strMenu = '';
foreach ($arrAllAccess as $arrPart=>$arrPage) {


    $SCondition = " Enabled = '$Enabled' and IdKey = '$arrPart' ORDER BY IdRow ";


    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    $objGlobalVar->setGetVarNull();
    $arrLinkMenu = array('ln' => @$strGlobalVarLanguage, 'part' => '', 'page' => '');
    foreach ($objORM->FetchAll($SCondition, 'PartName,IdKey,Name,FaIcon', TableIWPanelAdminPart) as $ListItem) {

        $arrLinkMenu['part'] = $ListItem->Name;
        $strMenu .= '<li><a><i class="fa ' . $ListItem->FaIcon . '"></i>';
        $strMenu .= $ListItem->PartName;
        $strMenu .= '<span class="fa fa-chevron-down"></span></a>';
        $strMenu .= '<ul class="nav child_menu">';
        $SCondition = " Enabled = '$Enabled' AND PartIdKey = '$ListItem->IdKey' and IdKey IN('".implode('\',\'',$arrPage)."')  ORDER BY IdRow ";

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
