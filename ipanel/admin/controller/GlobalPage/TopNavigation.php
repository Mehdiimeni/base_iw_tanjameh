<?php
//TopNavigation.php
require IW_ASSETS_FROM_PANEL . "include/DBLoaderPanel.php";
$Enabled = true;
$iw_admin_id = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWAdminId'));

$stdProfile = $objORM->Fetch(
    "iw_admin_id = $iw_admin_id",
    "Name,Image",
    TableIWAdminProfile
);

if (isset($stdProfile->Image)) {
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
    $objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
    $objShowFile->ShowImage('', $objShowFile->FileLocation("adminprofile"), $stdProfile->Image, $stdProfile->Name, 85, '') != null ? $AdminProfileImage = $objShowFile->ShowImage('', $objShowFile->FileLocation("adminprofile"), $stdProfile->Image, $stdProfile->Name, 85, '') : $AdminProfileImage = null;
} else {
    $AdminProfileImage = null;
}

/*
$strNewTicket = '';
$SCondition = " SetView = '0' Limit 0,10";
$intCountAllTicket = $objORM->DataCount($SCondition, TableIWTicket);

foreach ($objORM->FetchAll($SCondition, 'SenderIdKey,TicketSubject,last_modify', TableIWTicket) as $ListItem) {
    $SCondition = "id = '$ListItem->SenderIdKey'";
    $SenderName = @$objORM->Fetch($SCondition, 'Name', TableIWUser)->Name;
    $strNewTicket .= '<li><a href="?ln=&part=Ticket&page=UserTicket&modify=edit&ref=' . $objGlobalVar->en2Base64($ListItem->id . '::==::' . TableIWTicket, 0) . '"><span><span>' . $SenderName . '</span><span class="time">' . $ListItem->last_modify . '</span></span>
                      <span class="message">' . $ListItem->TicketSubject . '</span></a></li>';
}
$SCondition = " ChkState = 'none' and Enabled = $Enabled ";
$intCountAllShop = $objORM->DataCount($SCondition, TableIWAUserMainCart);
*/