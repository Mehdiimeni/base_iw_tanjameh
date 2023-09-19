<?php
//ManProductsImage.php

require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

$Enabled = true;

// Gender
$strurl_gender = '<option value=""></option>';


foreach ($objORM->FetchAll("1 GROUP BY  Name", 'Name', TableIWNewMenu) as $objPGander) {
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
$arrListcount = [25, 50, 75, 100];
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
    JavaTools::JsTimeRefresh(0, '?part=Products&page=ManProductsImage&ln=' . @$strGlobalVarLanguage . $strGetUrl);


}

if (isset($_POST['SubmitM'])) {


    $objTimeTools = new TimeTools();
    $objAclTools = new ACLTools();

    $modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
    $now_modify = date("Y-m-d H:i:s");
    $modify_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));


    $arrAllImageSelected = $_POST['ImageSelected'];


    foreach ($_POST['AllProduct'] as $AllProduct) {
        $id = $AllProduct;

        $USet = "";
        $USet .= " modify_ip = '$modify_ip' ,";
        $USet .= " modify_id = $modify_id ,";
        $USet .= " AdminOk = 2 ,";
        $USet .= " ImageSet = '' ";
        
        $UCondition = " id = '$id' ";
        $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

    }

    foreach ($arrAllImageSelected as $Keys => $Values) {

        foreach ($Values as $key => $value) {


            $id = $value;
            $ImageSet = $Keys;

            $USet = "";
            $USet .= " modify_ip = '$modify_ip' ,";
            $USet .= " modify_id = $modify_id ,";
            $USet .= " AdminOk = 1 ,";
            $USet .= " ImageSet = concat_ws(',',ImageSet,'" . $ImageSet . "') ";

            $UCondition = " id = '$id' ";
            $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

        }


    }

    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('act')));
    exit();

}


$strListHead = (new ListTools())->TableHead(
    array(
        '<input type="checkbox" checked="checked" name="All" id="checkAll"  class="flat checkboxbig">' . FA_LC['all'],
        '<input type="checkbox" name="cum1" checked="checked" id="check-cum1" class="flat checkboxbig master-sec-0 col-master">',
        '<input type="checkbox" name="cum2" checked="checked" id="check-cum2" class="flat checkboxbig master-sec-1 col-master">',
        '<input type="checkbox" name="cum3" checked="checked" id="check-cum3" class="flat checkboxbig master-sec-2 col-master">',
        '<input type="checkbox" name="cum4" checked="checked" id="check-cum4" class="flat checkboxbig master-sec-3 col-master">',
        '<input type="checkbox" name="cum5" checked="checked" id="check-cum5" class="flat checkboxbig master-sec-4 col-master">',
        '<input type="checkbox" name="cum6" checked="checked" id="check-cum6" class="flat checkboxbig master-sec-5 col-master">',
        '<input type="checkbox" name="cum7" checked="checked" id="check-cum6" class="flat checkboxbig master-sec-6 col-master">',
        '<input type="checkbox" name="cum8" checked="checked" id="check-cum7" class="flat checkboxbig master-sec-7 col-master">'
    ), FA_LC['name']
);


$ToolsIcons[] = $arrToolsIcon["view"];
$ToolsIcons[] = $arrToolsIcon["edit"];
$ToolsIcons[] = $arrToolsIcon["active"];
$ToolsIcons[] = $arrToolsIcon["delete"];

//image
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');


$SCondition = "id > 0";
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
        $SCondition .= "  and ( WeightIdRow IS NOT NULL )";
    } else {
        $SCondition .= "  and (NoWeightValue = '$Unweight' or WeightIdRow IS  NULL )";
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
    $SCondition = "ProductId = $strSearch OR 
                   id = $strSearch OR 
                   LocalName REGEXP '$strSearch' OR 
                   Name REGEXP '$strSearch' OR 
                   url_gender REGEXP '$strSearch' OR 
                   url_category REGEXP '$strSearch' OR 
                   url_group REGEXP '$strSearch' OR 
                   url_group2 REGEXP '$strSearch' OR 
                   ProductCode = $strSearch  ";
}
$intTotalFind = 0;
$intTotalFind = $objORM->DataCount($SCondition, ViewIWProductNotCheck);

$intRowCounter = 0;
$intIdMaker = 0;


$strListBody = '';

foreach ($objORM->FetchLimit($SCondition, 'Name,Content,ProductId,AdminOk,ImageSet,Url,id', 'id ASC', $strLimit, ViewIWProductNotCheck) as $ListItem) {


    $objArrayImage = explode("==::==", $ListItem->Content);

    $ListItem->Name = '<a target="_blank" href="' . $ListItem->Url . '">' . wordwrap($ListItem->Name, 15, "<br>\n") . '</a>';


    $ListItem->Content = '';
    $intImageCounter = 1;
    $strChecked = array(0 => '');
    foreach ($objArrayImage as $image) {
        $ListItem->Content .= $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->ProductId, 336, '');
        $strChecked[] = 'checked="checked"';


        if ($ListItem->AdminOk != 0) {

            if (@strpos($ListItem->ImageSet, (string) $intImageCounter) === false) {
                $strChecked[$intImageCounter] = '';
            }
            $intImageCounter++;
        }
    }


    isset($objArrayImage[0]) ? $strImage1 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[0] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-0" ' . @$strChecked[1] . ' value="' . $ListItem->id . '" id="' . ++$intIdMaker . '"  name="ImageSelected[1][]"><label for="' . $intIdMaker . '" >' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[0], $ListItem->ProductId, 336, 'id="myImg" class="cursor_pointer iw_image_edit_show"') . '</label>' : $strImage1 = '';
    isset($objArrayImage[1]) ? $strImage2 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[1] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-1" ' . @$strChecked[2] . ' value="' . $ListItem->id . '" id="' . ++$intIdMaker . '"  name="ImageSelected[2][]"><label for="' . $intIdMaker . '" >' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), @$objArrayImage[1], $ListItem->ProductId, 336, 'id="myImg"  class="cursor_pointer iw_image_edit_show"') . '</label>' : $strImage2 = '';
    isset($objArrayImage[2]) ? $strImage3 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[2] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-2" ' . @$strChecked[3] . ' value="' . $ListItem->id . '" id="' . ++$intIdMaker . '"  name="ImageSelected[3][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[2], $ListItem->ProductId, 336, 'id="myImg"  class="cursor_pointer iw_image_edit_show"') . '</label>' : $strImage3 = '';
    isset($objArrayImage[3]) ? $strImage4 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[3] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-3" ' . @$strChecked[4] . ' value="' . $ListItem->id . '" id="' . ++$intIdMaker . '"  name="ImageSelected[4][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[3], $ListItem->ProductId, 336, 'id="myImg"  class="cursor_pointer iw_image_edit_show"') . '</label>' : $strImage4 = '';
    isset($objArrayImage[4]) ? $strImage5 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[4] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-4" ' . @$strChecked[5] . ' value="' . $ListItem->id . '" id="' . ++$intIdMaker . '"  name="ImageSelected[5][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[4], $ListItem->ProductId, 336, 'id="myImg"  class="cursor_pointer iw_image_edit_show"') . '</label>' : $strImage5 = '';
    isset($objArrayImage[5]) ? $strImage6 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[5] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-5" ' . @$strChecked[6] . ' value="' . $ListItem->id . '" id="' . ++$intIdMaker . '"  name="ImageSelected[6][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[5], $ListItem->ProductId, 336, 'id="myImg"  class="cursor_pointer iw_image_edit_show"') . '</label>' : $strImage6 = '';
    isset($objArrayImage[6]) ? $strImage7 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[6] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-6" ' . @$strChecked[7] . ' value="' . $ListItem->id . '" id="' . ++$intIdMaker . '"  name="ImageSelected[7][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[6], $ListItem->ProductId, 336, 'id="myImg" class="cursor_pointer iw_image_edit_show"') . '</label>' : $strImage7 = '';
    isset($objArrayImage[7]) ? $strImage8 = '<a class="pimagemodalclass" href="#PImageModal" data-toggle="modal" data-img-url="' . $objShowFile->FileLocation("attachedimage") . @$objArrayImage[7] . '"> <i class="fa fa-search-plus fa-lg"></i> </a><input type="checkbox" class="flat child sec-' . $intRowCounter . ' sco-7" ' . @$strChecked[8] . ' value="' . $ListItem->id . '" id="' . ++$intIdMaker . '"  name="ImageSelected[8][]"><label for="' . $intIdMaker . '">' . $objShowFile->ShowImage('', $objShowFile->FileLocation("attachedimage"), $objArrayImage[7], $ListItem->ProductId, 336, 'id="myImg"  class="cursor_pointer iw_image_edit_show"') . '</label>' : $strImage8 = '';


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
    $strListBody .= '<input name="AllProduct[]" value="' . $ListItem->id . '" type="hidden">';
}

// list
if (@$_GET['list'] != '') {
    $_SESSION['strListSet'] = $_GET['list'];
} else {
    $_SESSION['strListSet'] = 'normal';
}