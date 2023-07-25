<?php
//ShopList.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$objGlobalVar = new GlobalVarTools();

$Enabled = true;
$Disabled = false;

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$objReqular = new Regularization();
$objTimeTools = new TimeTools();
$objAclTools = new ACLTools();

$modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();


$ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
$ModifyId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
$last_modifyNow = $objGlobalVar->Nu2EN($objTimeTools->jdate("Y/m/d"));


$strProductsShop = '';


// url
$ActualPageLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$UserId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
$UserSessionId = session_id();

$SCondition = "   UserId = '$UserId' GROUP BY BasketIdKey ORDER BY id DESC   ";
$objUserBasket = $objORM->FetchAll($SCondition, '*', TableIWAUserMainCart);


//array wig

$arrListProductShip = array();
$intPackcount = 0;
foreach ($objUserBasket as $UserBasket) {

    $SCondition = "   BasketIdKey = '$UserBasket->BasketIdKey'    ";
    $objUserMainCart = $objORM->FetchAll($SCondition, '*', TableIWAUserMainCart);
    foreach ($objUserMainCart as $UserMainCart) {

        $strSizeSelect = $UserMainCart->Size;
        $UserMainCart->Count != '' ? $intCountSelect = $UserMainCart->Count : $intCountSelect = 1;
        $SCondition = "Enabled = $Enabled AND  ProductId = '$UserMainCart->ProductId' ";

        $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);


        if ($UserMainCart->ChkState == 'none')
            $strStatus = FA_LC["status_property_none"];
        if ($UserMainCart->ChkState == 'bought')
            $strStatus = FA_LC["status_property_accept"];
        if ($UserMainCart->ChkState == 'preparation')
            $strStatus = FA_LC["status_property_preparation"];
        if ($UserMainCart->ChkState == 'packing')
            $strStatus = FA_LC["status_property_packing"];
        if ($UserMainCart->ChkState == 'booking')
            $strStatus = FA_LC["status_property_booking"];
        if ($UserMainCart->ChkState == 'dispatch')
            $strStatus = FA_LC["status_property_dispatch"];
        if ($UserMainCart->Enabled == '0')
            $strStatus = FA_LC["status_property_reject"];


        $objArrayImage = explode('==::==', $ListItem->Content);
        $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

        $intImageCounter = 1;
        foreach ($objArrayImage as $image) {
            if (@strpos($ListItem->ImageSet, (string)$intImageCounter) === false) {

                unset($objArrayImage[$intImageCounter]);
            }
            $intImageCounter++;
        }
        $objArrayImage = array_values($objArrayImage);


        $strProductsShop .= '<tr><td class="product-thumbnail">';
        $strProductsShop .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->id . '">';
        $strProductsShop .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->Name, 120, 'class="main-image"');
        $strProductsShop .= '</a></td><td class="product-name">';
        $strProductsShop .= '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->id . '">';
        $strProductsShop .= $ListItem->Name;
        $strProductsShop .= '</a><ul>';
        $strProductsShop .= '<li>' . FA_LC["color"] . ': <span>' . $ListItem->Color . '</span></li>';
        $strProductsShop .= '<li>' . FA_LC["size"] . ': <span>' . $strSizeSelect . '</span></li>';
        $strProductsShop .= '<li>' . FA_LC["brand"] . ':<span> ' . $ListItem->BrandName . '</span></li>';
        $strProductsShop .= '</ul></td><td class="products-size-wrapper">';
        $strProductsShop .= $strStatus;
        $strProductsShop .= '</td>';
        $strProductsShop .= '<td class="product-quantity">' . $intCountSelect . '</td>';
        $strProductsShop .= '<td class="product-quantity">' . $UserMainCart->last_modify . '</td>';
    }


    $strProductsShop .= '<tr><td class="product-quantity"><a target="_blank" href="?ln=&part=User&page=Invocie&PaymentIdKey='.$UserMainCart->PaymentIdKey.'&BasketIdKey=' . $UserMainCart->BasketIdKey . '"><b>' . FA_LC["invocie"] . '</b></a></td></tr>';


}

