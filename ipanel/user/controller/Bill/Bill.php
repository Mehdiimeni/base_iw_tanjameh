<?php
// Bill.php
include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
// user profile
$Enabled = BoolEnum::BOOL_TRUE();
$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
$stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);
// Api name
$apiMainName = 'Bill?$filter=Customer_Id%20eq%20'.$stdProfile->ApiId;

$Enabled = BoolEnum::BOOL_TRUE();
$strListHead = (new ListTools())->TableHead(array(FA_LC["bill_id"], FA_LC["pay_id"],FA_LC["bill_type"],FA_LC["bill_price"], FA_LC["transaction_datetime"],FA_LC["tracking_number"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["active"];

$strListBody = '';

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

$arrSortTo = array('BillId', 'PayId','BillType','Amount', 'CreatedAt','Trace');
foreach ($objGlobalVar->ObjectJsonToSelectArray($objKMN->GetWithFilter(), 1) as $ListItem) {

    $BillType = substr($ListItem->BillId, -2, 1);
    $strBillType = 'نامشخص';

    switch ($BillType) {
        case "1":
            $strBillType = "آب";
            break;
        case "2":
            $strBillType = "برق";
            break;
        case "3":
            $strBillType = "گاز";
            break;
        case "4":
            $strBillType = "تلفن ثابت";
            break;
        case "5":
            $strBillType = "همراه";
            break;
        case "6":
            $strBillType = "عوارض شهرداری";
            break;
        case "7":
            $strBillType = "مالیات";
            break;
        case "8":
            $strBillType = "جرایم رانندگی";
            break;

    }
    $ListItem->BillType = $strBillType;

    if ($ListItem->IsActive == false) {
        $ToolsIcons[0] = $arrToolsIcon["inactiveapi"];
    } else {
        $ToolsIcons[0] = $arrToolsIcon["activeapi"];
    }

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 6, $objGlobalVar->en2Base64($ListItem->Id . '::==::' . $apiMainName, 0), $arrSortTo);
}



