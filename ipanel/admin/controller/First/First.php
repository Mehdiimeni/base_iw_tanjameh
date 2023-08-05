<?php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;
//user count
$intCountAllUser = $objORM->DataCount(" 1 order by id DESC ", TableIWUser, 'id');
$intCountTempCart = $objORM->DataCount("1", TableIWUserTempCart, 'id');
$intCountPaymentState = $objORM->DataCount("1", TableIWAPaymentState);


$intCartBought = $objORM->DataCount(
    " status = 'bought' ",
    ViewIWUserCart,
    'invoice_id'
);

$intCartSorting = $objORM->DataCount(
    " status = 'bought' or status = 'preparation'  ",
    ViewIWUserCart,
    'invoice_id'
);

$intCartPack = $objORM->DataCount(
    " status = 'bought' or status = 'preparation' or packing_number is null  ",
    ViewIWUserCart,
    'invoice_id'
);

$intCartBooking = $objORM->DataCount(
    " status = 'packing' group by packing_number  ",
    ViewIWUserCart,
    'invoice_id'
);

$intCartDispatch = $objORM->DataCount(
    " (status = 'booking' or status = 'dispatch' )   group by packing_number  ",
    ViewIWUserCart,
    'invoice_id'
);

$intCartDelivery = $objORM->DataCount(
    " status = 'dispatch'  group by packing_number  ",
    ViewIWUserCart,
    'invoice_id'
);


$intCartClaim = $objORM->DataCount(
    " status = 'booking'  and (cop_file is null or cop_file= '')  group by packing_number   ",
    ViewIWUserCart,
    'invoice_id'
);

$intCartComplete = $objORM->DataCount(
    " (cop_file is not null or cop_file <> '')  ",
    ViewIWUserCart,
    'invoice_id'
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