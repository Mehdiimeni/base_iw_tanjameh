<?php
//Account.php

(new MakeDirectory)->MKDir(IW_REPOSITORY_FROM_PANEL . 'log/login/', 'user', 0755);

$objGlobalVar = new GlobalVarTools();
$objAclTools = new ACLTools();

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";

$Enabled = BoolEnum::BOOL_TRUE();
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
$stdProfile = $objORM->Fetch($SCondition, '*', TableIWUser);

if ($stdProfile->ChangePass) {

    (new FileCaller)->FileIncluderWithControler(IW_WEB_FROM_PANEL, 'User', 'ChangePass');
    exit();
}


if ($objGlobalVar->JsonDecode($objGlobalVar->ServerVarToJson())->HTTP_HOST == 'localhost')
    error_reporting(E_ALL);


if (@$objAclTools->NormalUserLogin(IW_REPOSITORY_FROM_PANEL . 'log/login/user/' . $UserIdKey)) {

    (new FileCaller)->FileIncluderWithControler(IW_WEB_FROM_PANEL, 'User', 'Login');
}



$SCondition = "IdKey = '$stdProfile->GroupIdKey'";
$strAdminGroupName = @$objORM->Fetch($SCondition, 'Name', TableIWUserGroup)->Name;


// address
$SCondition = "UserIdKey = '$stdProfile->IdKey'";
$strAddressUser = @$objORM->Fetch($SCondition, 'Address', TableIWUserAddress)->Address;



$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);

$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
$strUserProfileImage = $objShowFile->ShowImage('', $objShowFile->FileLocation("userprofile"), $stdProfile->Image, $stdProfile->Name, 75, 'class="shadow-sm"');

// Message to all
$strMessageToAll = '';

// note to all
$strNoteToAll = '';

// Count Property
$CountProperty = 0;
$SCondition = "UserIdKey = '$stdProfile->IdKey'";
$CountProperty = @$objORM->Fetch($SCondition, 'SUM(Count) as CountProperty ', TableIWAUserMainCart)->CountProperty;

// Ticket

if (isset($_POST['SubmitM'])) {

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $TicketSubject = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->TicketSubject);
        $SenderTicket = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->SenderTicket);


        $objTimeTools = new TimeTools();
        $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
        $ModifyTime = $objTimeTools->jdate("H:i:s");
        $ModifyDate = $objTimeTools->jdate("Y/m/d");

        $IdKey = $objAclTools->IdKey();

        $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
        $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
        $InSet = "";
        $InSet .= " IdKey = '$IdKey' ,";
        $InSet .= " Enabled = '$Enabled' ,";
        $InSet .= " TicketSubject = '$TicketSubject' ,";
        $InSet .= " SenderTicket = '$SenderTicket' ,";
        $InSet .= " SenderIdKey = '$ModifyId' ,";
        $InSet .= " SetView = '0' ,";
        $InSet .= " SetPart = 'user' ,";
        $InSet .= " ModifyIP = '$ModifyIP' ,";
        $InSet .= " ModifyTime = '$ModifyTime' ,";
        $InSet .= " ModifyDate = '$ModifyDate' ,";
        $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
        $InSet .= " ModifyId = '$ModifyId' ";

        $objORM->DataAdd($InSet, TableIWTicket);
        $_POST = array();
        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
        exit();


    }

}

// All Ticket
$strTicketAll = '';
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$SCondition = "SenderIdKey = '$UserIdKey' and Enabled = '$Enabled' ";
foreach ($objORM->FetchAll($SCondition, '*', TableIWTicket) as $ListItem) {

    $strTicketAll .= '<li class="comment"><article class="comment-body"><footer class="comment-meta"><div class="comment-author vcard">';
    $strTicketAll .= $strUserProfileImage;
    $strTicketAll .= '<b class="fn">' . $stdProfile->Name . '</b>';
    $strTicketAll .= '<span class="says">says:</span>';
    $strTicketAll .= '</div><div class="comment-metadata"><a href="#">';
    $strTicketAll .= '<span>' . $ListItem->ModifyDate . ' ' . $ListItem->ModifyTime . '</span>';
    $strTicketAll .= '</a></div></footer><div class="comment-content">';
    $strTicketAll .= '<p>' . $ListItem->TicketSubject . '</p>';
    $strTicketAll .= '<p>' . $ListItem->SenderTicket . '</p>';
    $strTicketAll .= '</div>';
    //$strTicketAll .= '<div class="reply"><a href="#" class="comment-reply-link">Reply</a></div>';
    if ($ListItem->AnswerTicket != '')
        $strTicketAll .= '<div class="reply">' . $ListItem->AnswerTicket . '</div>';
    $strTicketAll .= '</article> </li>';


}

// Basket

$arrAddToCart = '';
/*isset($_COOKIE["addtocart"]) ? $arrAddToCart = json_decode($_COOKIE["addtocart"]) : $arrAddToCart = array();
$arrAddToCart = (array)$arrAddToCart;
if (count($arrAddToCart) > 0)
    $arrAddToCart = array_filter($arrAddToCart);
*/
$UserIdKey = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$UserSessionId = session_id();

$SCondition = "  ( UserIdKey = '$UserIdKey' or UserSessionId = '$UserSessionId' ) and ProductId != ''  ";
$objUserTempCart = $objORM->FetchAll($SCondition, '*', TableIWUserTempCart);
$intCountAddToCart = $objORM->DataCount($SCondition, TableIWUserTempCart);
$strProductsCart = '';

foreach ($objUserTempCart as $UserTempCart) {
    $strPricingPart = '';
  //  if ($productIdBasket == null)
   //     continue;

    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$UserTempCart->ProductId' ";

    $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

    if (!isset($ListItem->IdKey)) {
        continue;
    }

    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
    $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
    $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
    $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
    $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;


    if ($CarentCurrencyPrice != null) {
        $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
        $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
        $strPricingPart .= '<span class="new-price">' . $CarentCurrencyPrice . '</span>';
    }


    $arrImages = explode('==::==', $ListItem->Content);

    $strProductsCart .= '<article class="item">';
    $strProductsCart .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsCart .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $arrImages[0], $ListItem->Name, 120, 'class="thumb"');
    $strProductsCart .= '</a>';
    $strProductsCart .= '<div class="info">';
    $strProductsCart .= '<h4 class="title usmall">';
    $strProductsCart .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsCart .= $ListItem->Name . '</a></h4>';
    $strProductsCart .= ' </div>';
    $strProductsCart .= $strPricingPart;
    $strProductsCart .= '<div class="clear"></div>';
    $strProductsCart .= '</article>';


}


// wishlist
$strProductsWishlist = '';
isset($_COOKIE["wishlist"]) ? $arrWishlist = json_decode($_COOKIE["wishlist"]) : $arrWishlist = array();

foreach ($arrWishlist as $productIdBasket) {
    $strPricingPart = '';
    if ($productIdBasket == null)
        continue;

    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$productIdBasket' ";

    $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);
    if (!isset($ListItem->IdKey)) {
        continue;
    }

    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
    $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
    $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
    $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
    $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;
    if ($CarentCurrencyPrice != null) {
        $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
        $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
        $strPricingPart .= '<span class="new-price">' . $CarentCurrencyPrice . '</span>';
    }


    $arrImages = explode('==::==', $ListItem->Content);

    $strProductsWishlist .= '<article class="item">';
    $strProductsWishlist .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsWishlist .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $arrImages[0], $ListItem->Name, 120, 'class="thumb"');
    $strProductsWishlist .= '</a>';
    $strProductsWishlist .= '<div class="info">';
    $strProductsWishlist .= '<h4 class="title usmall">';
    $strProductsWishlist .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';
    $strProductsWishlist .= $ListItem->Name . '</a></h4>';
    $strProductsWishlist .= ' </div>';
    $strProductsWishlist .= $strPricingPart;
    $strProductsWishlist .= '<div class="clear"></div>';
    $strProductsWishlist .= '</article>';


}

// Old Buy

$strOldBuylist = '';































