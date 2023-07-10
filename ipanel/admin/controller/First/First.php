<?php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;
//user count
$SCondition = " Enabled != 0 ";
$intCountAllUser = $objORM->DataCount($SCondition, TableIWUser, 'id');
$intCountTempCart = $objORM->DataCount($SCondition, TableIWUserTempCart, 'id');
$intCountPaymentState = $objORM->DataCount($SCondition, TableIWAPaymentState);


$intCountMainCartNone = $objORM->DataCount(
    TableIWUserOrderStatus . '.status = "none"',
    TableIWUserShopOrder . ' left join ' . TableIWUserOrderStatus . ' on ' . TableIWUserShopOrder . '.iw_user_order_status_id = ' . TableIWUserOrderStatus . '.id',
    TableIWUserShopOrder . '.id'
);


$intCountMainCartBought = $objORM->DataCount(
    TableIWUserOrderStatus . '.status = "bought"',
    TableIWUserShopOrder . ' left join ' . TableIWUserOrderStatus . ' on ' . TableIWUserShopOrder . '.iw_user_order_status_id = ' . TableIWUserOrderStatus . '.id',
    TableIWUserShopOrder . '.id'
);

$intCountMainCartPack = $objORM->DataCount(
    TableIWUserOrderStatus . '.status = "bought" or ' . TableIWUserOrderStatus . '.status = "preparation"',
    TableIWUserShopOrder . ' left join ' . TableIWUserOrderStatus . ' on ' . TableIWUserShopOrder . '.iw_user_order_status_id = ' . TableIWUserOrderStatus . '.id',
    TableIWUserShopOrder . '.id'
);

$intCountMainCartBooking = $objORM->DataCount(
    TableIWUserOrderStatus . '.status = "packing"',
    TableIWUserShopOrder . ' left join ' . TableIWUserOrderStatus . ' on ' . TableIWUserShopOrder . '.iw_user_order_status_id = ' . TableIWUserOrderStatus . '.id',
    TableIWUserShopOrder . '.id'
);

$intCountMainCartDispatch = $objORM->DataCount(
    TableIWUserOrderStatus . '.status = "booking"',
    TableIWUserShopOrder . ' left join ' . TableIWUserOrderStatus . ' on ' . TableIWUserShopOrder . '.iw_user_order_status_id = ' . TableIWUserOrderStatus . '.id',
    TableIWUserShopOrder . '.id'
);

$intCountMainCartDelivery = $objORM->DataCount(
    TableIWUserOrderStatus . '.status = "delivery"',
    TableIWUserShopOrder . ' left join ' . TableIWUserOrderStatus . ' on ' . TableIWUserShopOrder . '.iw_user_order_status_id = ' . TableIWUserOrderStatus . '.id',
    TableIWUserShopOrder . '.id'
);

$intCountMainCartClaim = $objORM->DataCount(
    TableIWUserOrderStatus . '.status = "claim"',
    TableIWUserShopOrder . ' left join ' . TableIWUserOrderStatus . ' on ' . TableIWUserShopOrder . '.iw_user_order_status_id = ' . TableIWUserOrderStatus . '.id',
    TableIWUserShopOrder . '.id'
);

$intCountMainCartAll = $objORM->DataCount(
    TableIWUserOrderStatus . '.status = "complete"',
    TableIWUserShopOrder . ' left join ' . TableIWUserOrderStatus . ' on ' . TableIWUserShopOrder . '.iw_user_order_status_id = ' . TableIWUserOrderStatus . '.id',
    TableIWUserShopOrder . '.id'
);



//conversation
$strCurrency = '';
foreach ($objORM->FetchAllWhitoutCondition('iw_currencies_id1,iw_currencies_id2,Rate,last_modify,id', TableIWACurrenciesConversion) as $ListItem) {


    $SCondition = "id = $ListItem->iw_currencies_id1";
    $ListItem->iw_currencies_id1 = @$objORM->Fetch($SCondition, 'Name', TableIWACurrencies)->Name;

    $SCondition = "id = $ListItem->iw_currencies_id2";
    $ListItem->iw_currencies_id2 = @$objORM->Fetch($SCondition, 'Name', TableIWACurrencies)->Name;

    $ListItem->Rate = $objGlobalVar->NumberFormat($ListItem->Rate);
    $ListItem->Rate = '<input type="text" class="currency_ex"  size="16" id="' . $ListItem->id . '" value="' . $ListItem->Rate . '">';


    $strCurrency .= '<tr>';
    $strCurrency .= '<td>' . $ListItem->iw_currencies_id1 . '</td>';
    $strCurrency .= '<td>' . $ListItem->iw_currencies_id2 . '</td>';
    $strCurrency .= '<td>' . $ListItem->Rate . '</td>';
    $strCurrency .= '<td>' . $ListItem->last_modify . '</td>';
    $strCurrency .= '</tr>';
}

// main page status
$arrSprakLineOne = array();
$iw_website_pages_id = $objORM->Fetch(
    "name = 'MenFirstPage'",
    "id",
    TableIWWebSitePages
)->id;
$SCondition = "  iw_website_pages_id = $iw_website_pages_id GROUP BY expire_date ";
foreach ($objORM->FetchAll($SCondition, 'all_count,expire_date', TableIWStatusView) as $StatusView) {
    $arrSprakLineOne[] = $StatusView->all_count;
}