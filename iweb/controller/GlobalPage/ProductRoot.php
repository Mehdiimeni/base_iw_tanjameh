<?php

require_once IW_ASSETS_FROM_PANEL . "include/DBLoader.php";

$Enabled = BoolEnum::BOOL_TRUE();
$Disabled = BoolEnum::BOOL_FALSE();

$objAclTools = new ACLTools();
$objReqular = new Regularization();
$objTimeTools = new TimeTools();

$ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
$ModifyTime = $objTimeTools->jdate("H:i:s");
$ModifyDate = $objTimeTools->jdate("Y/m/d");
$ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;

$ModifyDateNow = $objAclTools->Nu2EN($objTimeTools->jdate("Y/m/d"));


$objAsos = new AsosConnections();

$SCondition = "   RootDateCheck IS NULL ";
foreach ($objORM->FetchLimit($SCondition, '*', 'IdRow',2,TableIWAPIProducts) as $objProduct) {

    $arrCatId = explode(",", $objProduct->CatId);
    if (is_array($arrCatId)) {
        $arrCatId = array_unique($arrCatId);
        $strCatId = implode(",", $arrCatId);
    } else {
        $strCatId = $objProduct->CatId;
    }


    $ApiContent = $objAsos->ProductsDetail($objProduct->ProductId);
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

//Size
    $arrSize = array();
    $arrSizeDis = array();
    $strSize = '';
    $strSizeDis = '';
    if (is_array(@$objProductData['variants'])) {
        foreach ($objProductData['variants'] as $Size) {
            if (!$Size['isInStock'])
                $arrSizeDis[] = $Size['brandSize'];

            $arrSize[$Size['id']] = $Size['brandSize'];

        }
        $arrSize = array_unique($arrSize);
        $arrSizeDis = array_unique($arrSizeDis);
        $strSize = implode(",", $arrSize);
        $strSizeDis = implode(",", $arrSizeDis);
    }

    $parts = parse_url($objReqular->FindUrlInString($objProductData['description']));
    $arrPath = array_filter(explode("/", $parts['path']));
    unset($arrPath[count($arrPath)]);


    $objProductData['price']['previous']['value'] != null ? $ApiLastPrice = $objProductData['price']['previous']['value'] : $ApiLastPrice = 0;


    $strColor = str_replace('"', "", $strColor);
    $strColor = str_replace("'", "", $strColor);

    $USet = " ApiContent = '$ApiContent', ";
    $USet .= " LastPrice = $ApiLastPrice, ";
    $USet .= " ProductType = '$ProductType', ";
    $USet .= " PGender = '$arrPath[1]' ,";
    $USet .= " PCategory = '$arrPath[2]' ,";
    $USet .= " Color = '$strColor', ";
    $USet .= " Size = '$strSize', ";
    $USet .= " SizeDis = '$strSizeDis', ";
    $USet .= " CatId = '$strCatId', ";
    $USet .= " ModifyIP = '$ModifyIP' ,";
    $USet .= " ModifyTime = '$ModifyTime' ,";
    $USet .= " ModifyDate = '$ModifyDate' ,";
    $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
    $USet .= " RootDateCheck = '$ModifyStrTime' ,";
    $USet .= " ModifyId = '' ";

    if (isset($arrPath[3]))
        $USet .= ", PGroup = '$arrPath[3]' ";
    if (isset($arrPath[4]))
        $USet .= ", PGroup2 = '$arrPath[4]' ";

    if (!$objProductData['isInStock']){
            $USet .= ", Enabled = $Disabled";

        }else{
            $USet .= ", Enabled = $Enabled";
        }

    $objORM->DataUpdate("IdKey = '$objProduct->IdKey' ", $USet, TableIWAPIProducts);
}
