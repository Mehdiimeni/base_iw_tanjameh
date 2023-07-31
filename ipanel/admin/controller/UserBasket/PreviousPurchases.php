<?php
//PreviousPurchases.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(
    FA_LC["status"],
    FA_LC["user"],
    FA_LC["name"],
    FA_LC["product"],
    FA_LC["product_code"],
    FA_LC["image"],
    FA_LC["size"],
    FA_LC["count_property"],
    FA_LC["date"],
    FA_LC["order_number"],
    FA_LC["barcode_number"],
    FA_LC["packing_number"],
    FA_LC["dispatch_number"],
    FA_LC["tracking_number"],
    FA_LC["weight"],
    FA_LC["address"]), FA_LC["tools"]);


$strListBody = '';
@$_GET['s'] != null ? $getStart = @$_GET['s'] : $getStart = 0;
@$_GET['e'] != null ? $getEnd = @$_GET['e'] : $getEnd = 100;

$SCondition = " ";


if (isset($_POST['SubmitSearch'])) {
    $strSearch = @$_POST['Search'];
    $SCondition = "product_id = $strSearch OR 
                   last_modify LIKE '%$strSearch%' OR 
                   user_id = $strSearch OR 
                   user_shopping_cart_id = $strSearch OR 
                   payment_id = $strSearch OR 
                   product_code = '$strSearch' OR 
                   id = $strSearch OR 
                   barcode_number = $strSearch OR 
                   packing_number = $strSearch OR 
                   DispatchNu = '$strSearch' OR 
                   packing_weight REGEXP '$strSearch' OR 
                   address = '$strSearch' OR 
                   tracking_number = '$strSearch' ";
} else {
    $SCondition = " Enabled != 2  ";
}

$SCondition .= " and ChkState = 'complete'  order by id DESC limit " . $getStart . " , " . $getEnd;


foreach ($objORM->FetchAll($SCondition, 'id,ChkState,user_id,user_shopping_cart_id,product_id,product_code,ProductSizeId,Size,Count,last_modify,OrderNu,SortingNu,PackingNu,DispatchNu,TrackingNu,PackWeight,UserAddressId,Enabled', ViewIWUserCart) as $ListItem) {


    $SCondition = "id = $ListItem->iw_user_id";
    $ListItem->iw_user_id = @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;


    $SCondition = "  product_id = '$ListItem->product_id' ";
    $APIProducts = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

    $SConditionAddress = "  IdKey = '$ListItem->UserAddressId' ";
    $ListItem->UserAddressId = $objORM->Fetch($SConditionAddress, 'Address', TableIWUserAddress)->Address;

    $objArrayImage = explode('==::==', $APIProducts->Content);
    $objArrayImage = array_combine(range(1, count($objArrayImage)), $objArrayImage);

    $ListItem->user_shopping_cart_id = $APIProducts->Name;
    $ListItem->Url = $APIProducts->Url;

    $intImageCounter = 1;
    foreach ($objArrayImage as $image) {
        if (@strpos($APIProducts->ImageSet, (string)$intImageCounter) === false) {

            unset($objArrayImage[$intImageCounter]);
        }
        $intImageCounter++;
    }
    $objArrayImage = array_values($objArrayImage);


    $urlWSize = explode("?", basename($ListItem->Url));
    $urlWSize = str_replace(basename($ListItem->Url), $ListItem->ProductSizeId . '?' . $urlWSize[1], $ListItem->Url);
    $ListItem->user_shopping_cart_id = '<a target="_blank" href="https://www.asos.com/' . $urlWSize . '">' . $ListItem->user_shopping_cart_id . '</a>';
    $ListItem->ProductSizeId = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $APIProducts->Name, 120, 'class="main-image"');


    $strPricingPart = '';
    $strSizeSelect = '';
    $intCountSelect = 1;


    $strSizeSelect = $ListItem->Size;
    $ListItem->Count != '' ? $intCountSelect = $ListItem->Count : $intCountSelect = 1;


    if ($ListItem->Enabled == false) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 18, $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWAUserMainCart, 0));
}





