<?php
// Topup.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
// user profile
$Enabled = true;
$UserId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
$SCondition = "id = '$UserId' and  Enabled = $Enabled ";
$stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);
// Api name
$apiMainName = 'Topup?$filter=Customer_Id%20eq%20'.$stdProfile->ApiId;

$Enabled = true;
$strListHead = (new ListTools())->TableHead(array( FA_LC["operator"], FA_LC["mobile"],FA_LC["charge_type"],FA_LC["charge_price"] , FA_LC["transaction_datetime"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["active"];

$strListBody = '';

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

$arrSortTo = array( 'PinType','CellNumber','Type','Amount', 'CreatedAt', 'Operator');
foreach ($objGlobalVar->ObjectJsonToSelectArray($objKMN->GetWithFilter(), 1) as $ListItem) {


    $strPinType = FA_LC["unknown"];

    switch ($ListItem->Operator) {
        case "Irmci":
            $strPinType = FA_LC["irmci"];
            break;
        case "Irancell":
            $strPinType = FA_LC["irancell"];
            break;
        case "Taliya":
            $strPinType = FA_LC["taliya"];
            break;
        case "Rightel":
            $strPinType = FA_LC["rightel"];
            break;
    }
    $ListItem->PinType = $strPinType;

    if ($ListItem->IsActive == false) {
        $ToolsIcons[0] = $arrToolsIcon["inactiveapi"];
    } else {
        $ToolsIcons[0] = $arrToolsIcon["activeapi"];
    }

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 5, $objGlobalVar->en2Base64($ListItem->Id . '::==::' . $apiMainName, 0), $arrSortTo);
}



