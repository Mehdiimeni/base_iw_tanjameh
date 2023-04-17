<?php
// MainDataLoader.php
// API Count and Connect
$objAsos = new AsosConnections();

$Enabled = BoolEnum::BOOL_TRUE();

$objAclTools = new ACLTools();
$objTimeTools = new TimeTools();

$ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
$ModifyTime = $objTimeTools->jdate("H:i:s");
$ModifyDate = $objTimeTools->jdate("Y/m/d");
$ModifyStrTime = $objAclTools->JsonDecode($objTimeTools->getDateTimeNow())->date;

$ModifyDateNow = $objAclTools->Nu2EN($objTimeTools->jdate("Y/m/d"));


$objAPIAllData = $objORM->Fetch("Enabled = $Enabled  and ( CategoryId IS NOT NULL OR CategoryId = '' ) and ModifyDate = '$ModifyDateNow' and CreateCad = 0 and TypeSet = 'Product' ", '*', TableIWAPIAllCat);


$AllProductsContent = $objAsos->ProductsList($objAPIAllData->CategoryId);
$strExpireDate = date("m-Y");
$UCondition = " CompanyIdKey = '4a897b83' and ExpireDate = '$strExpireDate' ";
$USet = " Count = Count + 1 ";
$objORM->DataUpdate($UCondition, $USet, TableIWAPIAllConnect);

if ($AllProductsContent == '') {
    // set sub menu 2 listed
    $UCondition = " IdKey = '$objAPIAllData->IdKey' ";
    $USet = " Enabled = 0 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllCat);
} else {


    $PGender = $objAPIAllData->Main;
    $PCategory = $objAPIAllData->Sub;
    $PGroup = $objAPIAllData->Sub2;
    $PGroup2 = $objAPIAllData->Sub3;
    $CatId = $objAPIAllData->CategoryId;
    $TypeSet = $objAPIAllData->TypeSet;


    if (!$objORM->DataExist(" CatId = '$CatId' ", TableIWAPIAllProducts)) {
        $IdKey = $objAclTools->IdKey();

        $InSet = "";
        $InSet .= " IdKey = '$IdKey' ,";
        $InSet .= " Enabled = '$Enabled' ,";
        $InSet .= " CompanyIdKey = '4a897b83' ,";
        $InSet .= " CatId = '$CatId' ,";
        $InSet .= " Content = '$AllProductsContent' ,";
        $InSet .= " PGender = '$PGender' ,";
        $InSet .= " PCategory = '$PCategory' ,";
        $InSet .= " PGroup = '$PGroup' ,";
        $InSet .= " PGroup2 = '$PGroup2' ,";
        $InSet .= " SetProductChange = 0 ,";
        $InSet .= " TypeSet = '$TypeSet' ,";
        $InSet .= " ModifyIP = '$ModifyIP' ,";
        $InSet .= " ModifyTime = '$ModifyTime' ,";
        $InSet .= " ModifyDate = '$ModifyDate' ,";
        $InSet .= " ModifyStrTime = '$ModifyStrTime' ,";
        $InSet .= " ModifyId = '' ";

        $objORM->DataAdd($InSet, TableIWAPIAllProducts);
    } else {

        $USet = "";
        $USet .= " Content = '$AllProductsContent' ,";
        $USet .= " PGender = '$PGender' ,";
        $USet .= " PCategory = '$PCategory' ,";
        $USet .= " PGroup = '$PGroup' ,";
        $USet .= " PGroup2 = '$PGroup2' ,";
        $USet .= " SetProductChange = 0 ,";
        $USet .= " TypeSet = '$TypeSet' ,";
        $USet .= " ModifyIP = '$ModifyIP' ,";
        $USet .= " ModifyTime = '$ModifyTime' ,";
        $USet .= " ModifyDate = '$ModifyDate' ,";
        $USet .= " ModifyStrTime = '$ModifyStrTime' ";

        $objORM->DataUpdate("   CatId = '$CatId'   ", $USet, TableIWAPIAllProducts);

    }


    $UCondition = " IdKey = '$objAPIAllData->IdKey' ";
    $USet = " CreateCad = 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWAPIAllCat);


    // menu
    $UCondition = " CatId = '$CatId' ";
    $USet = " CreateCad = 1 ";
    $objORM->DataUpdate($UCondition, $USet, TableIWWebSubMenu);
    $objORM->DataUpdate($UCondition, $USet, TableIWWebSub2Menu);
    $objORM->DataUpdate($UCondition, $USet, TableIWWebSub3Menu);


}
