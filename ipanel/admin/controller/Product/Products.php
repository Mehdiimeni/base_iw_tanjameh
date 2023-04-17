<?php
//Products.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();

//Api count
/*
$strExpireDate = date("m-Y");
$SCondition = " ExpireDate = '$strExpireDate' and  CompanyIdKey = '4a897b83' ";
$intApiCount = $objORM->DataCount($SCondition, TableIWAPIAllConnect));
*/

// Gender
$strPGender = '<option value=""></option>';


foreach ($objORM->FetchAll("1 GROUP BY  Name", 'Name,IdKey', TableIWNewMenu) as $objPGander) {
    $strSelected = '';
    if (@$_GET['PGender'] == $objPGander->Name and isset($_GET['PGender']))
        $strSelected = 'selected';
    $strPGender .= '<option ' . $strSelected . ' value="' . $objPGander->Name . '" >' . $objPGander->Name . '</option>';
}

// Category
$strPCategory = '<option value=""></option>';
if (isset($_GET['PCategory']))
    $strPCategory .= '<option selected value="' . $_GET['PCategory'] . '">' . $_GET['PCategory'] . '</option>';


// Group
$strPGroup = '<option value=""></option>';
if (isset($_GET['PGroup']))
    $strPGroup .= '<option selected value="' . $_GET['PGroup'] . '">' . $_GET['PGroup'] . '</option>';

// Group2
$strPGroup2 = '<option value=""></option>';
if (isset($_GET['PGroup2']))
    $strPGroup2 .= '<option selected value="' . $_GET['PGroup2'] . '">' . $_GET['PGroup2'] . '</option>';


// ProductType
$strPProductType = '<option  value=""></option>';


foreach ($objORM->FetchAll("ProductType != '' GROUP BY  ProductType", 'ProductType', TableIWAPIProducts) as $objProductType) {
    $strSelected = '';
    if ((@$_GET['ProductType'] == $objProductType->ProductType) and $objProductType->ProductType != '' and isset($_GET['ProductType']) )
        $strSelected = 'selected';
    $strPProductType .= '<option ' . $strSelected . ' value="' . $objProductType->ProductType . '" >' . $objProductType->ProductType . '</option>';
}

// BrandName
$strPBrandName = '<option  value=""></option>';


foreach ($objORM->FetchAll("BrandName != '' GROUP BY  BrandName", 'BrandName', TableIWAPIProducts) as $objBrandName) {
    $strSelected = '';
    if ((@$_GET['BrandName'] == @$objBrandName->BrandName) and $objBrandName->BrandName != '' and isset($_GET['BrandName']) )
        $strSelected = 'selected';
    $strPBrandName .= '<option ' . $strSelected . ' value="' . $objBrandName->BrandName . '" >' . $objBrandName->BrandName . '</option>';
}


// Set Edit
$strSetEdit = '<option selected value="" ></option>';

$arrListSet = [0 => FA_LC['no_viewed'], 1 => FA_LC['observed'], 2 => FA_LC['reject']];

foreach ($arrListSet as $key => $value) {
    $strSelected = '';
    if (@$_GET['SetEdit'] == $key and isset($_GET['SetEdit']))
        $strSelected = 'selected';
    $strSetEdit .= '<option ' . $strSelected . ' value="' . $key . '" >' . $value . '</option>';
}


//Count show
$arrListcount = [25, 50, 100, 200, 500];
$strCountShow = '';
foreach ($arrListcount as $Listcount) {
    $strSelected = '';
    if (@$_GET['CountShow'] == $Listcount and isset($_GET['CountShow']))
        $strSelected = 'selected';
    $strCountShow .= '<option ' . $strSelected . ' value="' . $Listcount . '" >' . $Listcount . '</option>';
}

//Activity
$strActivity = '<option value="" ></option>';
$arrActivity = [0 => FA_LC['inactive'], 1 => FA_LC['active']];

foreach ($arrActivity as $key => $value) {
    $strSelected = '';
    if (@$_GET['PActivity'] == $key and isset($_GET['PActivity']))
        $strSelected = 'selected';

    $strActivity .= '<option ' . $strSelected . ' value="' . $key . '" >' . $value . '</option>';
}

//Unweight
$strUnweight = '<option value="" ></option>';
$arrUnweight = [0 => FA_LC['wweight'], 1 => FA_LC['unweight']];

foreach ($arrUnweight as $key => $value) {
    $strSelected = '';
    if (@$_GET['PUnweight'] == $key and isset($_GET['PUnweight']))
        $strSelected = 'selected ';

    $strUnweight .= '<option  ' . $strSelected . ' value="' . $key . '" >' . $value . '</option>';
}
if (isset($_POST['SubmitF'])) {


    $PGender = @$_POST['PGender'];
    $PCategory = @$_POST['PCategory'];
    $PGroup = @$_POST['PGroup'];
    $PGroup2 = @$_POST['PGroup2'];
    $ProductType = @$_POST['ProductType'];
    $BrandName = @$_POST['BrandName'];
    $SetEdit = @$_POST['SetEdit'];
    $CountShow = @$_POST['CountShow'];
    $PActivity = @$_POST['PActivity'];
    $PUnweight = @$_POST['PUnweight'];

    $strGetUrl = '';

    if ($PGender != '')
        $strGetUrl .= '&PGender=' . $objGlobalVar->getUrlDecode($PGender);
    if ($PCategory != '')
        $strGetUrl .= '&PCategory=' . $objGlobalVar->getUrlDecode($PCategory);
    if ($PGroup != '')
        $strGetUrl .= '&PGroup=' . $objGlobalVar->getUrlDecode($PGroup);
    if ($PGroup2 != '')
        $strGetUrl .= '&PGroup2=' . $objGlobalVar->getUrlDecode($PGroup2);
    if ($ProductType != '')
        $strGetUrl .= '&ProductType=' . $objGlobalVar->getUrlDecode($ProductType);
    if ($BrandName != '')
        $strGetUrl .= '&BrandName=' . $objGlobalVar->getUrlDecode($BrandName);
    if ($PActivity != '')
        $strGetUrl .= '&PActivity=' . $objGlobalVar->getUrlDecode($PActivity);
    if ($PUnweight != '')
        $strGetUrl .= '&PUnweight=' . $objGlobalVar->getUrlDecode($PUnweight);
    if ($SetEdit != '')
        $strGetUrl .= '&SetEdit=' . $SetEdit;
    if ($CountShow != '')
        $strGetUrl .= '&CountShow=' . $CountShow;

    $objGlobalVar->JustUnsetGetVar(array('PGroup,PGender,BrandName,ProductType,PCategory,PActivity,PUnweight,SetEdit,CountShow'));
    JavaTools::JsTimeRefresh(0, '?part=Products&page=Products&ln=' . @$strGlobalVarLanguage . $strGetUrl);

}
$strListHead = (new ListTools())->TableHead(array(FA_LC["date"], FA_LC["image"], FA_LC["code"], FA_LC["characteristic"], FA_LC["name"], FA_LC["gender"], FA_LC["category"], FA_LC["group"],FA_LC["group2"],'Attribute',FA_LC["type"],FA_LC["brand"], FA_LC["price"], FA_LC["weight"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');

$objStorageTools = new StorageTools($objFileToolsInit->KeyValueFileReader()['MainName']);
$objStorageTools->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
$SCondition = " 1 ";
if (@$_GET['PGender'] != '') {
    $strPGenderValue = $_GET['PGender'];
    $SCondition .= "  and PGender = '$strPGenderValue'";
}


if (@$_GET['PCategory'] != '') {
    $strPCategoryValue = $_GET['PCategory'];
    $SCondition .= "  and PCategory REGEXP '$strPCategoryValue'";
}


if (@$_GET['PGroup'] != '') {
    $strPGroupValue = $_GET['PGroup'];
    $SCondition .= "  and PGroup REGEXP '$strPGroupValue'";
}

if (@$_GET['PGroup2'] != '') {
    $strPGroup2Value = $_GET['PGroup2'];
    $SCondition .= "  and PGroup2 REGEXP '$strPGroup2Value'";
}

if (@$_GET['ProductType'] != '') {
    $strPProductTypeValue = $_GET['ProductType'];
    $SCondition .= "  and ProductType = '$strPProductTypeValue'";
}

if (@$_GET['BrandName'] != '') {
    $strPBrandNameValue = $_GET['BrandName'];
    $SCondition .= "  and BrandName = '$strPBrandNameValue'";
}

if (@$_GET['PActivity'] != '') {
    $Activity = $_GET['PActivity'];
    $SCondition .= "  and Enabled = '$Activity'";
}

if (@$_GET['PUnweight'] != '') {
    $Unweight = $_GET['PUnweight'];

    if($Unweight == 0) {
        $SCondition .= "  and ( WeightIdKey IS NOT NULL )";
    }else{
        $SCondition .= "  and (NoWeightValue = '$Unweight' or WeightIdKey IS  NULL )";
    }
}


if (@$_GET['SetEdit'] == 1)
    $SCondition .= "   and AdminOk = 1";
if (@$_GET['SetEdit'] == 2)
    $SCondition .= "   and AdminOk = 2 ";

if (@$_GET['SetEdit'] == 0 and isset($_GET['SetEdit']))
    $SCondition .= "   and AdminOk = 0 ";


if (@$_GET['CountShow'] != '') {
    $strLimit = @$_GET['CountShow'];
} else {
    $strLimit = '25';
}

$intRowCounter = 0;
$intIdMaker = 0;


$strListBody = '';

$strListBody = '';

if (isset($_POST['SubmitSearch'])) {
    $strSearch = @$_POST['Search'];
    $SCondition = "ProductId LIKE '%$strSearch%' OR 
                   ModifyDate LIKE '%$strSearch%' OR 
                   IdKey LIKE '%$strSearch%' OR 
                   LocalName REGEXP '%$strSearch%' OR 
                   Name REGEXP '%$strSearch%' OR 
                   PGender REGEXP '%$strSearch%' OR 
                   PCategory REGEXP '%$strSearch%' OR 
                   PGroup REGEXP '%$strSearch%' OR 
                   PGroup2 REGEXP '%$strSearch%' OR 
                   Attribute REGEXP '%$strSearch%' OR 
                   BrandName REGEXP '%$strSearch%' OR 
                   ProductType REGEXP '%$strSearch%' ";
}
$intTotalFind = 0;
$intTotalFind = $objORM->DataCount($SCondition,TableIWAPIProducts);

foreach ($objORM->FetchLimit($SCondition, 'ApiContent,ModifyDate,Content,IdKey,ProductId,Name,PGender,PCategory,PGroup,PGroup2,Attribute,ProductType,BrandName,MainPrice,WeightIdKey,ModifyId,Enabled,IdRow', 'IdRow DESC', $strLimit, TableIWAPIProducts) as $ListItem) {

    var_dump( $objAclTools->JsonDecodeArray($objAclTools->deBase64($ListItem->ApiContent)));
    exit();
    $ListItem->ModifyId == null ? $ListItem->ModifyId = FA_LC["no_viewed"] : FA_LC["viewed"];


    // add  weight product
    $SCondition = "IdKey = '$ListItem->WeightIdKey'";
    $ListItem->WeightIdKey = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->WeightIdKey = '<input type="text" class="weight-product" maxlength="3" size="3" id="' . $ListItem->ProductId . '" value="' . $ListItem->WeightIdKey . '">';


    // add weight gender
    $PGenderName = $ListItem->PGender;
    $MainWeightIdKey = $objORM->Fetch(" Name = '$PGenderName'", 'WeightIdKey', TableIWWebMainMenu)->WeightIdKey;
    $SCondition = "IdKey = '$MainWeightIdKey'";
    $WeightValue = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->PGender = $ListItem->PGender . '<br /><input type="text" class="weight-main" maxlength="3" size="3" id="' . $PGenderName . '" value="' . $WeightValue . '">';


    // add weight category
    $PCategoryName = $ListItem->PCategory;
    $SubWeightIdKey = @$objORM->Fetch(" Name = '$PCategoryName'", 'WeightIdKey', TableIWWebSubMenu)->WeightIdKey;
    $SCondition = "IdKey = '$SubWeightIdKey'";
    $WeightValue = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->PCategory = $ListItem->PCategory . '<br /><input type="text" class="weight-sub" maxlength="3" size="3" id="' . $objGlobalVar->getUrlDecode($PCategoryName) . '" value="' . $WeightValue . '">';

    // add weight group
    $PGroupName = $ListItem->PGroup;
    $Sub2WeightIdKey = @$objORM->Fetch(" Name = '$PGroupName'", 'WeightIdKey', TableIWWebSub2Menu)->WeightIdKey;
    $SCondition = "IdKey = '$Sub2WeightIdKey'";
    $WeightValue = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->PGroup = $ListItem->PGroup . '<br /><input type="text" class="weight-sub2" maxlength="3" size="3" id="' . $objGlobalVar->getUrlDecode($PGroupName) . '" value="' . $WeightValue . '">';

    // add weight submit 4
    $PAttribute = $ListItem->Attribute;
    $Sub4WeightIdKey = @$objORM->Fetch(" Name = '$PAttribute'", 'WeightIdKey', TableIWWebSub4Menu)->WeightIdKey;
    $SCondition = "IdKey = '$Sub4WeightIdKey'";
    $WeightValue = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->Attribute = $ListItem->Attribute . '<br /><input type="text" class="weight-sub4" maxlength="3" size="3" id="' . $objGlobalVar->getUrlDecode($PAttribute) . '" value="' . $WeightValue . '">';


    $SArgument = "'$ListItem->IdKey','c72cc40d','fea9f1bf'";

    $objArrayImage = explode("==::==", $ListItem->Content);

    $ListItem->Name = $objGlobalVar->StrTruncate($ListItem->Name, 60);


    $ListItem->Content = ' <a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[0] . '"> <i class="fa fa-search-plus "></i>  ' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->ProductId, 30, '');


    if ($ListItem->Enabled == BoolEnum::BOOL_FALSE()) {
        $ToolsIcons[2] = $arrToolsIcon["inactive"];
    } else {
        $ToolsIcons[2] = $arrToolsIcon["active"];
    }

    if (@$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->act != 'move') {

        $ToolsIcons[4] = $arrToolsIcon["move"];

    } elseif ($objGlobalVar->JsonDecode($objGlobalVar->GetVarToJsonNoSet())->act == 'move' and @$objGlobalVar->RefFormGet()[0] == $ListItem->IdKey) {
        $ToolsIcons[4] = $arrToolsIcon["movein"];
        $ToolsIcons[5] = $arrToolsIcon["closemove"];
        $objGlobalVar->setGetVar('chin', $ListItem->IdRow);


    } else {

        $ToolsIcons[4] = $arrToolsIcon["moveout"];
        $urlAppend = $ToolsIcons[4][3] . '&chto=' . $ListItem->IdRow . '&chin=' . @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->chin;
        $ToolsIcons[4][3] = $urlAppend;

    }
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 14, $objGlobalVar->en2Base64($ListItem->IdKey . '::==::' . TableIWAPIProducts, 0));
}



