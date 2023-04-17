<?php
//ManProductsImage.php

include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = BoolEnum::BOOL_TRUE();

// Gender
$strPGender = '<option value=""></option>';


foreach ($objORM->FetchAll("1 GROUP BY  Name", 'Name', TableIWNewMenu) as $objPGander) {
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
    if ((@$_GET['ProductType'] == $objProductType->ProductType) and $objProductType->ProductType != '' and isset($_GET['ProductType']))
        $strSelected = 'selected';
    $strPProductType .= '<option ' . $strSelected . ' value="' . $objProductType->ProductType . '" >' . $objProductType->ProductType . '</option>';
}

// BrandName
$strPBrandName = '<option  value=""></option>';


foreach ($objORM->FetchAll("BrandName != '' GROUP BY  BrandName", 'BrandName', TableIWAPIProducts) as $objBrandName) {
    $strSelected = '';
    if ((@$_GET['BrandName'] == @$objBrandName->BrandName) and $objBrandName->BrandName != '' and isset($_GET['BrandName']))
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
$arrListcount = [25,50, 75, 100, 125, 150];
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
    JavaTools::JsTimeRefresh(0, '?part=Products&page=ManProductsImage&ln=' . @$strGlobalVarLanguage . $strGetUrl);


}

if (isset($_POST['SubmitM'])) {


    $objTimeTools = new TimeTools();
    $objAclTools = new ACLTools();

    $ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    $ModifyTime = $objTimeTools->jdate("H:i:s");
    $ModifyDate = $objTimeTools->jdate("Y/m/d");
    $ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;
    $ModifyId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminIdKey'));

    $arrAllImageSelected = $_POST['ImageSelected'];


    foreach ($_POST['AllProduct'] as $AllProduct) {
        $IdKey = $AllProduct;

        $USet = "";
        $USet .= " ModifyIP = '$ModifyIP' ,";
        $USet .= " AdminOk = 2 ,";
        $USet .= " ImageSet = '' ,";
        $USet .= " ModifyTime = '$ModifyTime' ,";
        $USet .= " ModifyDate = '$ModifyDate' ,";
        $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
        $USet .= " ModifyId = '$ModifyId' ";


        $UCondition = " IdKey = '$IdKey' ";
        $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

    }

    foreach ($arrAllImageSelected as $Keys => $Values) {

        foreach ($Values as $key => $value) {


            $IdKey = $value;
            $ImageSet = $Keys;


            $USet = "";
            $USet .= " ModifyIP = '$ModifyIP' ,";
            $USet .= " AdminOk = 1 ,";
            $USet .= " ImageSet = concat_ws(',',ImageSet,'" . $ImageSet . "') ,";
            $USet .= " ModifyTime = '$ModifyTime' ,";
            $USet .= " ModifyDate = '$ModifyDate' ,";
            $USet .= " ModifyStrTime = '$ModifyStrTime' ,";
            $USet .= " ModifyId = '$ModifyId' ";

            $UCondition = " IdKey = '$IdKey' ";
            $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);


        }


    }

    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act')));
    exit();


}


$strListHead = (new ListTools())->TableHead(array('<input type="checkbox" checked="checked" name="All" id="checkAll"  class="flat checkboxbig">' . FA_LC['all'],
    '<input type="checkbox" name="cum1" checked="checked" id="check-cum1" class="flat checkboxbig master-sec-0 col-master">',
    '<input type="checkbox" name="cum2" checked="checked" id="check-cum2" class="flat checkboxbig master-sec-1 col-master">',
    '<input type="checkbox" name="cum3" checked="checked" id="check-cum3" class="flat checkboxbig master-sec-2 col-master">',
    '<input type="checkbox" name="cum4" checked="checked" id="check-cum4" class="flat checkboxbig master-sec-3 col-master">',
    '<input type="checkbox" name="cum5" checked="checked" id="check-cum5" class="flat checkboxbig master-sec-4 col-master">',
    '<input type="checkbox" name="cum6" checked="checked" id="check-cum6" class="flat checkboxbig master-sec-5 col-master">',
    '<input type="checkbox" name="cum7" checked="checked" id="check-cum6" class="flat checkboxbig master-sec-6 col-master">',
    '<input type="checkbox" name="cum8" checked="checked" id="check-cum7" class="flat checkboxbig master-sec-7 col-master">'), FA_LC['name']);


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
$SCondition = "Content IS NOT NULL and ApiContent IS NOT NULL and CatId IS NOT NULL ";
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

if (@$_GET['SetEdit'] == 0 or @$_GET['SetEdit'] == '' or !isset($_GET['SetEdit']))
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
                   LocalName REGEXP '$strSearch' OR 
                   Name REGEXP '$strSearch' OR 
                   PGender REGEXP '$strSearch' OR 
                   PCategory REGEXP '$strSearch' OR 
                   PGroup REGEXP '$strSearch' OR 
                   PGroup2 REGEXP '$strSearch' OR 
                   ProductCode LIKE '%$strSearch%' OR 
                   BrandName REGEXP '$strSearch' OR 
                   ProductType REGEXP '$strSearch' ";
}
$intTotalFind = 0;
$intTotalFind = $objORM->DataCount($SCondition, TableIWAPIProducts);

$intRowCounter = 0;
$intIdMaker = 0;


$strListBody = '';


foreach ($objORM->FetchLimit($SCondition, 'Name,Content,ProductId,AdminOk,ImageSet,Url,IdKey', 'ModifyDate ASC', $strLimit, TableIWAPIProducts) as $ListItem) {


    $objArrayImage = explode("==::==", $ListItem->Content);

    $ListItem->Name = '<a target="_blank" href="https://www.asos.com/' . $ListItem->Url . '">' .  wordwrap($ListItem->Name,15,"<br>\n"). '</a>';


    $ListItem->Content = '';
    $intImageCounter = 1;
    $strChecked = array(0 => '');
    foreach ($objArrayImage as $image) {
        $ListItem->Content .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->ProductId, 120, '');
        $strChecked[] = 'checked="checked"';


        if ($ListItem->AdminOk != 0) {

            if (@strpos($ListItem->ImageSet, (string)$intImageCounter) === false) {
                $strChecked[$intImageCounter] = '';
            }
            $intImageCounter++;
        }
    }


    isset($objArrayImage[0]) ? $strImage1 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[0] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-0" ' . @$strChecked[1] . ' value="' . $ListItem->IdKey . '" id="' . ++$intIdMaker . '"  name="ImageSelected[1][]"><label for="' . $intIdMaker . '" >' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->ProductId, 120, 'id="myImg" class="cursor_pointer"') . '</label>' : $strImage1 = '';
    isset($objArrayImage[1]) ? $strImage2 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[1] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-1" ' . @$strChecked[2] . ' value="' . $ListItem->IdKey . '" id="' . ++$intIdMaker . '"  name="ImageSelected[2][]"><label for="' . $intIdMaker . '" >' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[1], $ListItem->ProductId, 120, 'id="myImg"  class="cursor_pointer"') . '</label>' : $strImage2 = '';
    isset($objArrayImage[2]) ? $strImage3 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[2] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-2" ' . @$strChecked[3] . ' value="' . $ListItem->IdKey . '" id="' . ++$intIdMaker . '"  name="ImageSelected[3][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[2], $ListItem->ProductId, 120, 'id="myImg"  class="cursor_pointer"') . '</label>' : $strImage3 = '';
    isset($objArrayImage[3]) ? $strImage4 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[3] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-3" ' . @$strChecked[4] . ' value="' . $ListItem->IdKey . '" id="' . ++$intIdMaker . '"  name="ImageSelected[4][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[3], $ListItem->ProductId, 120, 'id="myImg"  class="cursor_pointer"') . '</label>' : $strImage4 = '';
    isset($objArrayImage[4]) ? $strImage5 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[4] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-4" ' . @$strChecked[5] . ' value="' . $ListItem->IdKey . '" id="' . ++$intIdMaker . '"  name="ImageSelected[5][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[4], $ListItem->ProductId, 120, 'id="myImg"  class="cursor_pointer"') . '</label>' : $strImage5 = '';
    isset($objArrayImage[5]) ? $strImage6 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[5] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-5" ' . @$strChecked[6] . ' value="' . $ListItem->IdKey . '" id="' . ++$intIdMaker . '"  name="ImageSelected[6][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[5], $ListItem->ProductId, 120, 'id="myImg"  class="cursor_pointer"') . '</label>' : $strImage6 = '';
    isset($objArrayImage[6]) ? $strImage7 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[6] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-6" ' . @$strChecked[7] . ' value="' . $ListItem->IdKey . '" id="' . ++$intIdMaker . '"  name="ImageSelected[7][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[6], $ListItem->ProductId, 120, 'id="myImg" class="cursor_pointer"') . '</label>' : $strImage7 = '';
    isset($objArrayImage[7]) ? $strImage8 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[7] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-7" ' . @$strChecked[8] . ' value="' . $ListItem->IdKey . '" id="' . ++$intIdMaker . '"  name="ImageSelected[8][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[7], $ListItem->ProductId, 120, 'id="myImg"  class="cursor_pointer"') . '</label>' : $strImage8 = '';


    $strListBody .= '<tr><td><input type="checkbox" checked="checked" class="flat checkboxbig master-sco-' . $intRowCounter++ . ' row-master" name="row' . $ListItem->ProductId . '">' . $ListItem->ProductId . '</td>';
    $strListBody .= '<td>' . $strImage1 . '</td>';
    $strListBody .= '<td>' . $strImage2 . '</td>';
    $strListBody .= '<td>' . $strImage3 . '</td>';
    $strListBody .= '<td>' . $strImage4 . '</td>';
    $strListBody .= '<td>' . $strImage5 . '</td>';
    $strListBody .= '<td>' . $strImage6 . '</td>';
    $strListBody .= '<td>' . $strImage7 . '</td>';
    $strListBody .= '<td>' . $strImage8 . '</td>';
    $strListBody .= '<td  width="10%">' . $ListItem->Name . '</td>';
    $strListBody .= '</tr>';
    $strListBody .= '<input name="AllProduct[]" value="' . $ListItem->IdKey . '" type="hidden">';
}

// list
if (@$_GET['list'] != '') {
    $_SESSION['strListSet'] = $_GET['list'];
} else {
    $_SESSION['strListSet'] = 'normal';
}


