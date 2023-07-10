<?php
//PageAction.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
require_once IW_DEFINE_FROM_PANEL . 'conf/tablename.php';

$objTimeTools = new TimeTools();
$HourNow = $objTimeTools->jdate("H");

$modify_ip = (new IPTools(IW_DEFINE_FROM_PANEL))->getUserIP();


$ModifyStrTime = $objGlobalVar->JsonDecode($objTimeTools->getDateTimeNow())->date;

$NameApi = $objAsos->getName();

$Enabled = true;

if($ApiGetLive == 0) {

    $SCondition = "  Name = '$NameApi' and Enabled = $Enabled and Category = '$ApiCategoryName.$ApivarList'   ";
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
            $USet .= " modify_ip = '$modify_ip' ,";
            
            
            $USet .= " last_modify = '$now_modify' ";

            $objORM->DataUpdate($SCondition, $USet, TableIWAPIContents);

            $SCondition = "  Name = '$NameApi' and Enabled = $Enabled and Category = '$ApiCategoryName.$ApivarList'   ";
            $objApiContents = $objORM->Fetch($SCondition, 'ModifyStrTime,Content', TableIWAPIContents);
            $ApiContent = $objApiContents->Content;
        }


    } else {
        $SCondition = "  Name = '$NameApi'  and Category = '$ApiCategoryName.$ApivarList'   ";
        if ($objORM->DataExist($SCondition, TableIWAPIContents)) {
            $ApiContent = false;
        } else {

            $objAclTools = new ACLTools();
            $ApiContent = $objAsos->$ApiCategoryName($ApivarList);

            

            $InSet = " id = $IdKey , ";
            $InSet .= " Name = '$NameApi' ,";
            $InSet .= " Category = '$ApiCategoryName.$ApivarList' ,";
            $InSet .= " Content = '$ApiContent' ,";
            $InSet .= " ReplacePeriod = '2' ,";
            $InSet .= " modify_ip = '$modify_ip' ,";
            
            
            $InSet .= " last_modify = '$now_modify' ";

            $objORM->DataAdd($InSet, TableIWAPIContents);
            $SCondition = "  Name = '$NameApi' and Enabled = $Enabled and Category = '$ApiCategoryName.$ApivarList'   ";
            $objApiContents = $objORM->Fetch($SCondition, 'ModifyStrTime,Content', TableIWAPIContents);
            $ApiContent = $objApiContents->Content;
        }
    }
}else
{
    $ApiContent = $objAsos->$ApiCategoryName($ApivarList);
}



