<?php
//MenuPart.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";


$Enabled = BoolEnum::BOOL_TRUE();
$objAclTools = new ACLTools();
$objTimeTools = new TimeTools();
$ModifyDateNow = $objAclTools->Nu2EN($objTimeTools->jdate("Y/m/d"));

/*
$arrAddToCart = '';
isset($_COOKIE["addtocart"]) ? $arrAddToCart = json_decode($_COOKIE["addtocart"]) : $arrAddToCart = array();
$arrAddToCart = (array)$arrAddToCart;
if (count($arrAddToCart) > 0)
    $arrAddToCart = array_filter($arrAddToCart);

foreach ($arrAddToCart as $productIdBasket) {


    $strPricingPart = '';
    if ($productIdBasket == null) {
        if (($key = array_search($productIdBasket, $arrAddToCart)) !== false) {
            unset($arrAddToCart[$key]);
        }

        continue;
    }


    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$productIdBasket' ";


    $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

    if (!isset($ListItem->IdKey)) {
        if (($key = array_search($productIdBasket, $arrAddToCart)) !== false) {
            unset($arrAddToCart[$key]);
        }

        continue;
    }
}
*/
$UserIdKey = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$UserSessionId = session_id();

$SCondition = "  ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' )  and ProductId != '' ";
$intCountAddToCart = $objORM->DataCount($SCondition, TableIWUserTempCart);

$GId = 0;
$MainMenuSite = '';
//Brand Menu
/*
$MainMenuSite .= '<li class="nav-item " ><a title="' . FA_LC["brands"] . '"  href = "?part=Brand&page=Brands" class="nav-link" >' . FA_LC["brands"] . '</a>';
$MainMenuSite .= '<li class="nav-item " ><a title="' . FA_LC["size"] . '"  href = "?part=Brand&page=Size" class="nav-link" >' . FA_LC["size"] . '</a>';
$MainMenuSite .= '<li class="nav-item " ><a title="' . FA_LC["type"] . '"  href = "?part=Brand&page=Type" class="nav-link" >' . FA_LC["type"] . '</a>';
*/
//Product Menu

$SCondition = "Enabled = $Enabled and LocalName != ''  ";
foreach ($objORM->FetchAll($SCondition, 'Name,LocalName,ApiId,Description,IdKey', TableIWNewMenu) as $MainMenu) {
    $MainMenuSite .= '<li class="nav-item " ><a title="' . $MainMenu->Description . '"  href = "?Gender=' . $objGlobalVar->getUrlDecode($MainMenu->Name) . '" class="nav-link" >' . $MainMenu->LocalName . '<i class="bx bx-chevron-down"></i></a>';
    $MainMenuSite .= '<ul class="dropdown-menu">';

    $GroupIdKey = $MainMenu->IdKey;
    $SCondition2 = "Enabled = $Enabled  and GroupIdKey = '$GroupIdKey'   and LocalName != ''";


    foreach ($objORM->FetchAll($SCondition2, 'Name,ApiId,Description,IdKey,LocalName', TableIWNewMenu2) as $SubMenu) {

        $MainMenuSite .= '<li class="nav-item " ><a title="' . $SubMenu->Description . '" href = "?Gender=' . $objGlobalVar->getUrlDecode($MainMenu->Name) .  '&Category=' . $objGlobalVar->getUrlDecode($SubMenu->Name) .'&ProductList=1" class="nav-link" >' . $SubMenu->LocalName . '<i class="bx bx-chevron-down"></i></a>';
        $MainMenuSite .= '<ul class="dropdown-menu">';

        $Group2IdKey = $SubMenu->IdKey;
        $SCondition3 = "Enabled = $Enabled  and GroupIdKey = '$Group2IdKey' and CatId != ''   and LocalName != '' ";

        foreach ($objORM->FetchAll($SCondition3, 'Name,LocalName,ApiId,Description,CatId,ApiCategoryId', TableIWNewMenu3) as $Sub2Menu) {

            $MainMenuSite .= '<li class="nav-item"><a title="' . $Sub2Menu->Description . '" class="nav-link" href="?Gender=' . $objGlobalVar->getUrlDecode($MainMenu->Name) . '&Category=' . $objGlobalVar->getUrlDecode($SubMenu->Name) . '&Group=' . $objGlobalVar->getUrlDecode($Sub2Menu->Name) . '&ProductList=1&CatId='.$Sub2Menu->CatId.'" >' . $Sub2Menu->LocalName . '</a></li>';

        }
        $MainMenuSite .= '</ul>';
        $MainMenuSite .= '</li>';

    }

    $MainMenuSite .= '</ul></li>';
}

include "./view/GlobalPage/MenuPart.php";

