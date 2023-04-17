<?php
//PageAction.php
require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
require_once IW_DEFINE_FROM_PANEL . 'conf/tablename.php';

$objTimeTools = new TimeTools();
$HourNow = $objTimeTools->jdate("H");

$ModifyIP = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();
$ModifyTime = $objTimeTools->jdate("H:i:s");
$ModifyDate = $objTimeTools->jdate("Y/m/d");
$ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;

$NameApi = $objAsos->getName();

$Enabled = BoolEnum::BOOL_TRUE();

if($ApiGetLive == 0) {

    $SCondition = "  Name = '$NameApi' and Enabled = '$Enabled' and Category = '$ApiCategoryName.$ApivarList'   ";
    $objApiContents = $objORM->Fetch($SCondition, 'ModifyStrTime,Content', TableIWAPIContents);

    if ($objORM->DataExist($SCondition, TableIWAPIContents)) {


        $datetime1 = new DateTime();
        $datetime2 = new DateTime($objApiContents->ModifyStrTime);
        $interval = $datetime1->diff($datetime2);

        if ($interval->d < 1 and $objApiContents->Content != '') {

            $ApiContent = $objApiContents->Content;
        } else {

            $NewContents = $objAsos->$ApiCategoryName($ApivarList);

            $USet = " Content = '$NewContents' , ";
            $USet .= " ModifyIP = '$ModifyIP' ,";
            $USet .= " ModifyTime = '$ModifyTime' ,";
            $USet .= " ModifyDate = '$ModifyDate' ,";
            $USet .= " ModifyStrTime = '$ModifyStrTime' ";

            $objORM->DataUpdate($SCondition, $USet, TableIWAPIContents);

            $SCondition = "  Name = '$NameApi' and Enabled = '$Enabled' and Category = '$ApiCategoryName.$ApivarList'   ";
            $objApiContents = $objORM->Fetch($SCondition, 'ModifyStrTime,Content', TableIWAPIContents);
            $ApiContent = $objApiContents->Content;
        }


    } else {
        $SCondition = "  Name = '$NameApi'  and Category = '$ApiCategoryName.$ApivarList'   ";
        if ($objORM->DataExist($SCondition, TableIWAPIContents)) {
            $ApiContent = BoolEnum::BOOL_FALSE();
        } else {

            $objAclTools = new ACLTools();
            $ApiContent = $objAsos->$ApiCategoryName($ApivarList);

            $IdKey = $objAclTools->IdKey();

            $InSet = " IdKey = '$IdKey' , ";
            $InSet .= " Name = '$NameApi' ,";
            $InSet .= " Category = '$ApiCategoryName.$ApivarList' ,";
            $InSet .= " Content = '$ApiContent' ,";
            $InSet .= " ReplacePeriod = '2' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime' ";

            $objORM->DataAdd($InSet, TableIWAPIContents);
            $SCondition = "  Name = '$NameApi' and Enabled = '$Enabled' and Category = '$ApiCategoryName.$ApivarList'   ";
            $objApiContents = $objORM->Fetch($SCondition, 'ModifyStrTime,Content', TableIWAPIContents);
            $ApiContent = $objApiContents->Content;
        }
    }
}else
{
    $ApiContent = $objAsos->$ApiCategoryName($ApivarList);
}



