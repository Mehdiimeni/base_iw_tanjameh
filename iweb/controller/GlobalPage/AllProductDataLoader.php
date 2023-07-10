<?php
// MainDataLoader.php
// API Count and Connect
$objAsos = new AsosConnections();

$Enabled = true;

$objAclTools = new ACLTools();
$objTimeTools = new TimeTools();

$modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();


$now_modify = date("Y-m-d H:i:s");

$ModifyDateNow = $objAclTools->Nu2EN($objTimeTools->jdate("Y/m/d"));


$objAPIAllData = $objORM->Fetch("Enabled = $Enabled  and ( CategoryId IS NOT NULL OR CategoryId = '' ) and ModifyDate = '$ModifyDateNow' and CreateCad = 0 and TypeSet = 'Product' ", '*', TableIWAPIAllCat);


$AllProductsContent = $objAsos->ProductsList($objAPIAllData->CategoryId);
$expire_date = date("m-Y");
$UCondition = " iw_company_id = $obj_product->iw_company_id and expire_date = '$expire_date' ";
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
        

        $InSet = "";
        
        $InSet .= " Enabled = $Enabled ,";
        $InSet .= " iw_company_id = $obj_product->iw_company_id ,";
        $InSet .= " CatId = '$CatId' ,";
        $InSet .= " Content = '$AllProductsContent' ,";
        $InSet .= " PGender = '$PGender' ,";
        $InSet .= " PCategory = '$PCategory' ,";
        $InSet .= " PGroup = '$PGroup' ,";
        $InSet .= " PGroup2 = '$PGroup2' ,";
        $InSet .= " SetProductChange = 0 ,";
        $InSet .= " TypeSet = '$TypeSet' ,";
        $InSet .= " modify_ip = '$modify_ip' ,";
        
        
        $InSet .= " last_modify = '$now_modify' ,";
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
        $USet .= " modify_ip = '$modify_ip' ,";
        
        
        $USet .= " last_modify = '$now_modify' ";

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
