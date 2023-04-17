<?php
//Compare.php


require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";

$Enabled = BoolEnum::BOOL_TRUE();
$Disabled = BoolEnum::BOOL_FALSE();
$objAclTools = new ACLTools();
$objGlobalVar = new GlobalVarTools();

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$objReqular = new Regularization();
$objTimeTools = new TimeTools();

$ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
$ModifyTime = $objTimeTools->jdate("H:i:s");
$ModifyDate = $objTimeTools->jdate("Y/m/d");
$ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;
$ModifyId = @$objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));
$ModifyDateNow = $objGlobalVar->Nu2EN($objTimeTools->jdate("Y/m/d"));

isset($_COOKIE["comparison"]) ? $arrComparison = json_decode($_COOKIE["comparison"]) : $arrComparison = array();

$intCounter = 0;
$strPricingPart = array();
$strOldPricingPart = array();
$strLink = array();
$strImageSec = array();
$strImageOne = array();
$strName = array();
$strBrand = array();
$strProductType = array();
$strColor = array();
$strProductId = array();
$arrComparison = (array)$arrComparison;
$arrAllColor = array();
foreach ($arrComparison as $productIdBasket) {

    if ($productIdBasket == null) {
        if (($key = array_search($productIdBasket, $arrComparison)) !== false) {
            unset($arrComparison[$key]);
        }
        continue;
    }

    if ($intCounter > 3)
        continue;

    $intCounter++;

    $SCondition = "Enabled = '$Enabled' AND  ProductId = '$productIdBasket' ";

    $ListItem = $objORM->Fetch($SCondition, '*', TableIWAPIProducts);

    if (!isset($ListItem->IdKey)) {
        if (($key = array_search($productIdBasket, $arrComparison)) !== false) {
            unset($arrComparison[$key]);
        }
        continue;
    }
    $strProductId[$intCounter] = $productIdBasket;

    // API Count and Connect
    $objAsos = new AsosConnections();

    $ApiContent = $objAsos->ProductsDetail($ListItem->ProductId);
    $strExpireDate = date("m-Y");
    $UCondition = " CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ";
    $USet = " Count = Count + 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);
    $objProductData = $objReqular->JsonDecodeArray($objReqular->deBase64($ApiContent));


    $ProductType = $objProductData['productType']['name'] ?? null;


    //Color
    $arrColor = array();
    $arrColorDis = array();
    $strColor = '';
    if (is_array(@$objProductData['variants'])) {
        foreach ($objProductData['variants'] as $Color) {
            if (!$Color['isInStock'])
                $arrColorDis[] = $Color['colour'];

            $arrColor[] = $Color['colour'];
        }
        $arrColor = array_unique($arrColor);
        $strColor = implode(",", $arrColor);
    }

    $arrAllColor[] = $ListItem->Color;

//Size
    $arrSize = array();
    $arrSizeDis = array();
    $strSize = '';
    $strSizeDis = '';
    if (is_array(@$objProductData['variants'])) {
        foreach ($objProductData['variants'] as $Size) {
            if (!$Size['isInStock'])
                $arrSizeDis[] = $Size['brandSize'];

            $arrSize[] = $Size['brandSize'];

        }
        $arrSize = array_unique($arrSize);
        $arrSizeDis = array_unique($arrSizeDis);
        $strSize = implode(",", $arrSize);
        $strSizeDis = implode(",", $arrSizeDis);
    }

    $parts = parse_url($objReqular->FindUrlInString($objProductData['description']));
    $arrPath = array_filter(explode("/", $parts['path']));
    unset($arrPath[count($arrPath)]);


    if (!isset($objProductData['isInStock']))
        $strExistence = FA_LC["unavailable"];


    $objProductData['price']['previous']['value'] != null ? $ApiLastPrice = $objProductData['price']['previous']['value'] : $ApiLastPrice = 0;

    $arrCatId = explode(",", $ListItem->CatId);
    if (is_array($arrCatId)) {
        $arrCatId = array_unique($arrCatId);
        $strCatId = implode(",", $arrCatId);
    } else {
        $strCatId = $ListItem->CatId;
    }

    $USet = " ApiContent = '$ApiContent', ";
    $USet .= " LastPrice = $ApiLastPrice, ";
    $USet .= " ProductType = '$ProductType', ";
    $USet .= " CatId = '$strCatId', ";
    $USet .= " PGender = '$arrPath[1]' ,";
    $USet .= " PCategory = '$arrPath[2]' ,";
    $USet .= " Color = '$strColor', ";
    $USet .= " Size = '$strSize', ";
    $USet .= " SizeDis = '$strSizeDis', ";
    $USet .= " ModifyIP = '$ModifyIP' ,";
    $USet .= " ModifyTime = '$ModifyTime' ,";
    $USet .= " ModifyDate = '$ModifyDate' ,";
    $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
    $USet .= " RootDateCheck = '$ModifyStrTime' ,";
    $USet .= " ModifyId = '$ModifyId' ";

    if (isset($arrPath[3]))
        $USet .= ", PGroup = '$arrPath[3]' ";
    if (isset($arrPath[4]))
        $USet .= ", PGroup2 = '$arrPath[4]' ";

    if (!$objProductData['isInStock'])
        $USet .= ", Enabled = $Disabled";


    $objORM->DataUpdate($SCondition, $USet, TableIWAPIProducts);

    $strOtherData = $objProductData;


    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";
    $CarentCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncPricing);
    $PreviousCurrencyPrice = @$objORM->FetchFunc($SArgument, FuncIWFuncLastPricing);
    $CarentCurrencyPrice = $CarentCurrencyPrice[0]->Result;
    $PreviousCurrencyPrice = $PreviousCurrencyPrice[0]->Result;
    $boolChange = 0;

    if ($CarentCurrencyPrice != $PreviousCurrencyPrice and $PreviousCurrencyPrice != 0)
        $boolChange = 1;

    if ($CarentCurrencyPrice != null) {
        $CarentCurrencyPrice = $objGlobalVar->NumberFormat($CarentCurrencyPrice, 0, ".", ",");
        $CarentCurrencyPrice = $objGlobalVar->Nu2FA($CarentCurrencyPrice);
        @$strPricingPart[$intCounter] = $CarentCurrencyPrice;
    }

    if ($PreviousCurrencyPrice != null and $boolChange) {
        $PreviousCurrencyPrice = $objGlobalVar->NumberFormat($PreviousCurrencyPrice, 0, ".", ",");
        $PreviousCurrencyPrice = $objGlobalVar->Nu2FA($PreviousCurrencyPrice);
        @$strOldPricingPart[$intCounter] = $PreviousCurrencyPrice;
    }


    $arrImages = explode('==::==', $ListItem->Content);

    @$strLink[$intCounter] = '<a href="?Gender=' . $objGlobalVar->getUrlDecode($ListItem->PGender) . '&Category=' . $objGlobalVar->getUrlDecode($ListItem->PCategory) . '&CatId=' . $ListItem->CatId . '&Group=' . $objGlobalVar->getUrlDecode($ListItem->PGroup) . '&part=Product&page=ProductDetails&IdKey=' . $ListItem->IdKey . '">';


    @$strImageOne[$intCounter] = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $arrImages[0], $ListItem->Name, 120, 'class="main-image"');
    @$strImageSec[$intCounter] = $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $arrImages[1], $ListItem->Name, 120, 'class="hover-image"');
    @$strName[$intCounter] = $ListItem->Name;

    @$strBrand[$intCounter] = @$strOtherData['brand']['name'];
    @$strProductType[$intCounter] = @$strOtherData['productType']['name'];
    @$strColor[$intCounter] = @$strOtherData['variants'][0]['colour'];


}
