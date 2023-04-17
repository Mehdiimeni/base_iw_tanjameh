<?php
require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();
//user count
$SCondition = " Enabled != 0 ";
$intCountAllUser = $objORM->DataCount($SCondition, TableIWUser);
$intCountTempCart = $objORM->DataCount($SCondition, TableIWUserTempCart);
$intCountPaymentState = $objORM->DataCount($SCondition, TableIWAPaymentState);


$SCondition = " Enabled != 0 and ChkState = 'none' ";
$intCountMainCartNone = $objORM->DataCount($SCondition, TableIWAUserMainCart);

$SCondition = " Enabled != 0 and ChkState = 'bought' ";
$intCountMainCartBought = $objORM->DataCount($SCondition, TableIWAUserMainCart);

$SCondition = " Enabled != 0 and (ChkState = 'bought' or ChkState = 'preparation') ";
$intCountMainCartPack = $objORM->DataCount($SCondition, TableIWAUserMainCart);

$SCondition = " Enabled != 0 and (ChkState = 'packing' ) group by PackingNu ";
$intCountMainCartBooking = $objORM->DataCount($SCondition, TableIWAUserMainCart);

$SCondition = " Enabled != 0 and (ChkState = 'booking' )  ";
$intCountMainCartDispatch = $objORM->DataCount($SCondition, TableIWAUserMainCart);

$SCondition = " Enabled != 0 and (ChkState = 'delivery' )  ";
$intCountMainCartDelivery = $objORM->DataCount($SCondition, TableIWAUserMainCart);

$SCondition = " Enabled != 0 and (ChkState = 'claim' )  ";
$intCountMainCartClaim = $objORM->DataCount($SCondition, TableIWAUserMainCart);

$SCondition = " Enabled != 0 and (ChkState = 'complete' )  ";
$intCountMainCartAll = $objORM->DataCount($SCondition, TableIWAUserMainCart);

//conversation
$strCurrency = '';
foreach ($objORM->FetchAllWhitoutCondition('IdKey,CurrencyIdKey1,CurrencyIdKey2,Rate,ModifyDate,ModifyTime,ModifyId,Enabled,IdRow', TableIWACurrenciesConversion) as $ListItem) {


    $SCondition = "IdKey = '$ListItem->CurrencyIdKey1'";
    $ListItem->CurrencyIdKey1 = @$objORM->Fetch($SCondition, 'Name', TableIWACurrencies)->Name;

    $SCondition = "IdKey = '$ListItem->CurrencyIdKey2'";
    $ListItem->CurrencyIdKey2 = @$objORM->Fetch($SCondition, 'Name', TableIWACurrencies)->Name;

    $ListItem->Rate = $objGlobalVar->NumberFormat($ListItem->Rate);
    $ListItem->Rate = '<input type="text" class="currency_ex"  size="16" id="' . $ListItem->IdKey . '" value="' . $ListItem->Rate . '">';

    $ListItem->ModifyDate = $ListItem->ModifyTime . ' ' . $ListItem->ModifyDate;


    $strCurrency .= '<tr>';
    $strCurrency .= '<td>' . $ListItem->CurrencyIdKey1 . '</td>';
    $strCurrency .= '<td>' . $ListItem->CurrencyIdKey2 . '</td>';
    $strCurrency .= '<td>' . $ListItem->Rate . '</td>';
    $strCurrency .= '<td>' . $ListItem->ModifyDate . '</td>';
    $strCurrency .= '</tr>';
}

// main page status
$arrSprakLineOne = array();

$SCondition = "  Page = 'MainPage' GROUP BY ExpireDate ";
foreach ($objORM->FetchAll($SCondition, 'Count,ExpireDate', TableIWStatusView) as $StatusView) {
    $arrSprakLineOne[] = $StatusView->Count;
}










