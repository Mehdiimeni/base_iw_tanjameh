<?php
//CastomerPoint.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
include IW_ASSETS_FROM_PANEL . "include/UserInfo.php";
include IW_ASSETS_FROM_PANEL . "include/IconTools.php";
$objAclTools = new ACLTools();

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

$arrTypePoint = array(FA_LC["balance"], FA_LC["transfer"], FA_LC["transaction"], FA_LC["pin"], FA_LC["bill"], FA_LC["deposit"]
, FA_LC["lottery"], FA_LC["topup"]);

// user profile
$Enabled = true;

$UserId = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserId'));
$SCondition = "id = '$UserId' and  Enabled = $Enabled ";
$stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);

$apiMainName = 'PointStats/' . (int)$stdProfile->ApiId;


$Enabled = true;
$strListHead = (new ListTools())->TableHead(array(FA_LC["location"], FA_LC["score_value"]), FA_LC["tools"]);

$ToolsIcons[] = $arrToolsIcon["active"];

$strListBody = '';

$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
$objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['GenericApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

$arrSortTo = array('Type', 'Count');
foreach ($objGlobalVar->ObjectJsonToSelectArray($objKMN->Get(), 0)[0] as $ListItem) {
    $ListItem->Type = $arrTypePoint[$ListItem->Type];

    $strListBody .= (new ListTools())->TableBody($ListItem, $ToolsIcons, 2, $objGlobalVar->en2Base64($apiMainName, 0), $arrSortTo);
}


