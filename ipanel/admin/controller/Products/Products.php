<?php
//Products.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;
$objAclTools = new ACLTools();


// Gender
$strurl_gender = '<option value=""></option>';


foreach ($objORM->FetchAll("1 GROUP BY  Name", 'Name,IdKey', TableIWNewMenu) as $objPGander) {
    $strSelected = '';
    if (@$_GET['url_gender'] == $objPGander->Name and isset($_GET['url_gender']))
        $strSelected = 'selected';
    $strurl_gender .= '<option ' . $strSelected . ' value="' . $objPGander->Name . '" >' . $objPGander->Name . '</option>';
}

// Category
$strurl_category = '<option value=""></option>';
if (isset($_GET['url_category']))
    $strurl_category .= '<option selected value="' . $_GET['url_category'] . '">' . $_GET['url_category'] . '</option>';


// Group
$strurl_group = '<option value=""></option>';
if (isset($_GET['url_group']))
    $strurl_group .= '<option selected value="' . $_GET['url_group'] . '">' . $_GET['url_group'] . '</option>';

// Group2
$strurl_group2 = '<option value=""></option>';
if (isset($_GET['url_group2']))
    $strurl_group2 .= '<option selected value="' . $_GET['url_group2'] . '">' . $_GET['url_group2'] . '</option>';


//type
$str_product_type = '<option value=""></option>';
foreach ($objORM->FetchAll("1 GROUP BY  name", 'name,id', TableIWApiProductType) as $obj_product_type) {
    $strSelected = '';
    if (@$_GET['product_type'] == $obj_product_type->id and isset($_GET['product_type']))
        $strSelected = 'selected';
    $str_product_type .= '<option ' . $strSelected . ' value="' . $obj_product_type->id . '" >' . $obj_product_type->name . '</option>';
}


//brand
$str_brand = '<option value=""></option>';
foreach ($objORM->FetchAll("1 GROUP BY  name", 'name,id', TableIWApiBrands) as $obj_brand) {
    $strSelected = '';
    if (@$_GET['brand'] == $obj_brand->id and isset($_GET['brand']))
        $strSelected = 'selected';
    $str_brand .= '<option ' . $strSelected . ' value="' . $obj_brand->id . '" >' . $obj_brand->name . '</option>';
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
$arrListcount = [25, 50, 100, 150];
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


    $url_gender = @$_POST['url_gender'];
    $url_category = @$_POST['url_category'];
    $url_group = @$_POST['url_group'];
    $url_group2 = @$_POST['url_group2'];
    $product_type = @$_POST['product_type'];
    $brand = @$_POST['brand'];

    $SetEdit = @$_POST['SetEdit'];
    $CountShow = @$_POST['CountShow'];
    $PActivity = @$_POST['PActivity'];
    $PUnweight = @$_POST['PUnweight'];

    $strGetUrl = '';

    if ($url_gender != '')
        $strGetUrl .= '&url_gender=' . $objGlobalVar->getUrlDecode($url_gender);
    if ($url_category != '')
        $strGetUrl .= '&url_category=' . $objGlobalVar->getUrlDecode($url_category);
    if ($url_group != '')
        $strGetUrl .= '&url_group=' . $objGlobalVar->getUrlDecode($url_group);
    if ($url_group2 != '')
        $strGetUrl .= '&url_group2=' . $objGlobalVar->getUrlDecode($url_group2);
    if ($product_type != '')
        $strGetUrl .= '&product_type=' . $objGlobalVar->getUrlDecode($product_type);
    if ($brand != '')
        $strGetUrl .= '&brand=' . $objGlobalVar->getUrlDecode($brand);
    if ($PActivity != '')
        $strGetUrl .= '&PActivity=' . $objGlobalVar->getUrlDecode($PActivity);
    if ($PUnweight != '')
        $strGetUrl .= '&PUnweight=' . $objGlobalVar->getUrlDecode($PUnweight);
    if ($SetEdit != '')
        $strGetUrl .= '&SetEdit=' . $SetEdit;
    if ($CountShow != '')
        $strGetUrl .= '&CountShow=' . $CountShow;

    $objGlobalVar->JustUnsetGetVar(array('url_group,url_gender,url_category,product_type,brand,PActivity,PUnweight,SetEdit,CountShow'));
    JavaTools::JsTimeRefresh(0, '?part=Products&page=Products&ln=' . @$strGlobalVarLanguage . $strGetUrl);

}
$strListHead = (new ListTools())->TableHead(
    array(
        FA_LC["date"],
        FA_LC["image"],
        FA_LC["code"],
        FA_LC["characteristic"],
        FA_LC["name"],
        FA_LC["gender"],
        FA_LC["category"],
        FA_LC["group"],
        FA_LC["group2"],
        FA_LC["price"],
        FA_LC["type"],
        FA_LC["brand"],
        FA_LC["weight"]
    ), FA_LC["tools"]
);

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
if (@$_GET['url_gender'] != '') {
    $strurl_genderValue = $_GET['url_gender'];
    $SCondition .= "  and url_gender = '$strurl_genderValue'";
}


if (@$_GET['url_category'] != '') {
    $strurl_categoryValue = $_GET['url_category'];
    $SCondition .= "  and url_category REGEXP '$strurl_categoryValue'";
}


if (@$_GET['url_group'] != '') {
    $strurl_groupValue = $_GET['url_group'];
    $SCondition .= "  and url_group REGEXP '$strurl_groupValue'";
}

if (@$_GET['url_group2'] != '') {
    $strurl_group2Value = $_GET['url_group2'];
    $SCondition .= "  and url_group2 REGEXP '$strurl_group2Value'";
}

if (@$_GET['product_type'] != '') {
    $strurl_product_type = $_GET['product_type'];
    $SCondition .= "  and iw_api_product_type_id = '$strurl_product_type'";
}

if (@$_GET['brand'] != '') {
    $strurl_brand = $_GET['brand'];
    $SCondition .= "  and iw_api_brands_id = '$strurl_brand'";
}

if (@$_GET['PActivity'] != '') {
    $Activity = $_GET['PActivity'];
    $SCondition .= "  and Enabled = '$Activity'";
}

if (@$_GET['PUnweight'] != '') {
    $Unweight = $_GET['PUnweight'];

    if ($Unweight == 0) {
        $SCondition .= "  and ( WeightIdKey IS NOT NULL )";
    } else {
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

if (isset($_POST['SubmitSearch'])) {
    $strSearch = @$_POST['Search'];
    $SCondition = "ProductId LIKE '%$strSearch%' OR 
                   IdRow LIKE '%$strSearch%' OR 
                   LocalName REGEXP '$strSearch' OR 
                   Name REGEXP '$strSearch' OR 
                   url_gender REGEXP '$strSearch' OR 
                   url_category REGEXP '$strSearch' OR 
                   url_group REGEXP '$strSearch' OR 
                   url_group2 REGEXP '$strSearch' OR 
                   ProductCode LIKE '%$strSearch%'  ";
}
$intTotalFind = 0;
$intTotalFind = $objORM->DataCount($SCondition, TableIWAPIProducts);
foreach ($objORM->FetchLimit($SCondition, 'created_time,
Content,
ProductCode,
ProductId,
Name,
url_gender,
url_category,
url_group,
url_group2,
MainPrice,
iw_api_product_type_id,
iw_api_brands_id,
WeightIdKey,
Enabled,
modify_ip,
IdRow', 'IdRow ASC', $strLimit, TableIWAPIProducts) as $ListItem) {


    $ListItem->modify_ip == null ? $ListItem->modify_ip = FA_LC["no_viewed"] : FA_LC["viewed"];


    // add  weight product
    $SCondition = "IdKey = '$ListItem->WeightIdKey'";
    $ListItem->WeightIdKey = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->WeightIdKey = '<input type="text" class="weight-product" maxlength="3" size="3" id="' . $ListItem->ProductId . '" value="' . $ListItem->WeightIdKey . '">';


    // add weight gender
    $url_gender = $ListItem->url_gender;
    $MainWeightIdKey = $objORM->Fetch(" Name = '$url_gender'", 'WeightIdKey', TableIWNewMenu)->WeightIdKey;
    $SCondition = "IdKey = '$MainWeightIdKey'";
    $WeightValue = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->url_gender = $ListItem->url_gender . '<br /><input type="text" class="weight-main" maxlength="3" size="3" id="' . $url_gender . '" value="' . $WeightValue . '">';


    // add weight category
    $url_category = $ListItem->url_category;
    $SubWeightIdKey = @$objORM->Fetch(" Name = '$url_category'", 'WeightIdKey', TableIWNewMenu2)->WeightIdKey;
    $SCondition = "IdKey = '$SubWeightIdKey'";
    $WeightValue = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->url_category = $ListItem->url_category . '<br /><input type="text" class="weight-sub" maxlength="3" size="3" id="' . $objGlobalVar->getUrlDecode($url_category) . '" value="' . $WeightValue . '">';

    // add weight group
    $url_group = $ListItem->url_group;
    $Sub2WeightIdKey = @$objORM->Fetch(" Name = '$url_group'", 'WeightIdKey', TableIWNewMenu3)->WeightIdKey;
    $SCondition = "IdKey = '$Sub2WeightIdKey'";
    $WeightValue = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->url_group = $ListItem->url_group . '<br /><input type="text" class="weight-sub2" maxlength="3" size="3" id="' . $objGlobalVar->getUrlDecode($url_group) . '" value="' . $WeightValue . '">';

    // add weight submit 4
    $url_group2 = $ListItem->url_group2;
    $Sub4WeightIdKey = @$objORM->Fetch(" Name = '$url_group2'", 'WeightIdKey', TableIWNewMenu4)->WeightIdKey;
    $SCondition = "IdKey = '$Sub4WeightIdKey'";
    $WeightValue = @$objORM->Fetch($SCondition, 'Weight', TableIWWebWeightPrice)->Weight;
    $ListItem->url_group2 = $ListItem->url_group2 . '<br /><input type="text" class="weight-sub4" maxlength="3" size="3" id="' . $objGlobalVar->getUrlDecode($url_group2) . '" value="' . $WeightValue . '">';

    // brand
    $ListItem->iw_api_brands_id = @$objORM->Fetch("id = '$ListItem->iw_api_brands_id' ", 'name', TableIWApiBrands)->name;
    //type
    $ListItem->iw_api_product_type_id = @$objORM->Fetch("id = '$ListItem->iw_api_product_type_id' ", 'name', TableIWApiProductType)->name;

    $SArgument = "'$ListItem->IdRow','c72cc40d','fea9f1bf'";

    $objArrayImage = explode("==::==", $ListItem->Content);

    $ListItem->Name = $objGlobalVar->StrTruncate($ListItem->Name, 60);


    $ListItem->Content = ' <a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[0] . '"> <i class="fa fa-search-plus "></i>  ' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->ProductId, 336, 'id="myImg" class="cursor_pointer iw_image_edit_show"');


    if ($ListItem->Enabled == false) {
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
    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 13, $objGlobalVar->en2Base64($ListItem->IdRow . '::==::' . TableIWAPIProducts, 0));
}