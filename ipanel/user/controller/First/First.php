<?php
//First3.php
include_once IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
include_once IW_ASSETS_FROM_PANEL . "include/UserInfo.php";
$strNewUser = 0;
if ($stdProfile->ApiId != null) {

    $apiMainName = 'customer/' . (int)$stdProfile->ApiId;
    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

    $strPanTrunc = $objGlobalVar->JsonDecodeArray($objKMN->Get())['PanTrunc'];

    if ($objGlobalVar->JsonDecodeArray($objKMN->Get())['PanTrunc'] == null)
        $strNewUser = 1;


    //card info
    $apiMainName = 'CardInfo/' . (int)$stdProfile->ApiId;
    $objKMNInfo = new KMNConnection($objFileToolsInit->KeyValueFileReader()['GenericApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

    $arrUserCardInfo = $objGlobalVar->JsonDecodeArray($objKMNInfo->Get());

    // castomer point

    $apiMainName = 'PointStats/' . (int)$stdProfile->ApiId;
    $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['GenericApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

    $arrCastomerPoint = $objGlobalVar->ObjectJsonToSelectArray($objKMN->Get(), 0)[0];


// api stat
    $apiMainName = 'stats/' . (int)$stdProfile->ApiId;
    $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['GenericApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
    $arrState = $objGlobalVar->JsonDecodeArray($objKMN->connect());
} else {
    $strNewUser = 1;
}

$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile(IW_REPOSITORY_FROM_PANEL . 'img/');
$UserProfileImage = $objShowFile->ShowImage('', $objShowFile->FileLocation("userprofile"),  $stdProfile->Image, $stdProfile->Name, 85, 'style ="max-width: 100px; max-height: 100px"');

// adver marquee

$strMarquee = '<p>';
$SCondition = " Enabled = '1' Limit 0,10";
foreach ($objORM->FetchAll($SCondition,'Adver', TableIWAdver) as $ListItem) {
    $strMarquee .= ' <i class="fa fa-hand-o-left" aria-hidden="true"></i> '.$ListItem->Adver;
}
$strMarquee .= '</p>';
// trade position
if ($arrAllTrade != null) {
    $strTradePosition = '';

    foreach ($arrAllTrade as $Key => $AllValue) {
        $SCondition = "  IdKey = '$Key' ";
        $objTradeGroup = $objORM->Fetch($SCondition, 'Name', TableIWTradeGroup);
        foreach ($AllValue as $Value) {
            $SCondition = "  IdKey = '$Value' ";
            $objTrade = $objORM->Fetch($SCondition, 'Name', TableIWTrade);
            $SCondition = "  GroupIdKey = '$Key' and  	TradeIdKey = '$Value' ";
            $objTradePosition = $objORM->Fetch($SCondition, '*', TableIWTradePosition);
            if (@$objTradePosition->TypePosition == null)
                continue;
            $arrOpenPosition = explode(",", $objTradePosition->OpenPosition);
            $strOpenPosition = '';
            foreach ($arrOpenPosition as $OpenPosition) {
                $strOpenPosition .= '<li><i class="fa fa-check text-success"></i><strong class="label label-success"> ' . $OpenPosition . ' </strong></li>';
            }
            $objTradePosition->TypePosition == 'Buy' ? $strPriceClass = 'pricing' : $strPriceClass = 'pricing2';

            $strTradePosition .= '<div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="' . $strPriceClass . '">
                            <div class="title">
                                <h2>' . $objTradeGroup->Name . '</h2>
                                <h1>' . $objTrade->Name . '</h1>
                                <span>' . $objTradePosition->TypePosition . '</span>
                            </div>
                            <div class="x_content">
                                <div class="">
                                    <div class="pricing_features">
                                        <ul class="list-unstyled text-right">
                                            ' . $strOpenPosition . '
                                            <hr />
                                            <li><i class="fa fa-times text-danger"></i>
                                                <strong class="label label-danger">' . $objTradePosition->ClosePosition . '</strong> 
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="pricing_footer">
                                    <a href="javascript:void(0);" class="btn btn-success btn-block"
                                       role="button">' . $objTradePosition->TimePosition . '</a>
                                    <p>' . $objTradePosition->Description . '</p>
                                </div>
                            </div>
                        </div>
                    </div>';
        }

    }

}

// bank refer page
if (@$_GET['backset'] == 'pec') {

    $apiMainName = 'Transaction';
    include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
    include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

    $objAclTools = new ACLTools();

    try {

        $objParsianIPG = new \Pasargad\Pasargad('X4m6yOaH0em36yII45L6');
        $response = $objParsianIPG->verify();


    } catch (\Throwable $exception) {
        var_dump($exception->getMessage());
    }


    $PIN = 'X4m6yOaH0em36yII45L6';
    $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?WSDL";

    $Token = $_REQUEST ["Token"];
    $status = $_REQUEST ["status"];
    $OrderId = $_REQUEST ["OrderId"];
    $TerminalNo = $_REQUEST ["TerminalNo"];
    $Amount = $objAclTools->strReplace($_REQUEST ["Amount"], ",");
    $RRN = $_REQUEST ["RRN"];

    // user profile
    $Enabled = BoolEnum::BOOL_TRUE();
    $UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
    $SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
    $stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);
    $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

    $arrPost = array('Customer_Id' => (int)$stdProfile->ApiId, 'Amount' => (int)$Amount, 'Token' => (string)$Token, 'Status' => 0, 'OrderId' => (int)$OrderId, 'TerminalNumber' => (int)$TerminalNo, 'RRN' => (int)$RRN);
    $JsonPostData = $objAclTools->JsonEncode($arrPost);

    $objKMN->Post($JsonPostData);

    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, '?ln=&part=Report&page=Transaction');
    exit();


}
if (@$_GET['backset'] == 'pecl') {
    $apiMainName = 'Transaction';
    include IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
    include IW_ASSETS_FROM_PANEL . "include/IconTools.php";

    $objAclTools = new ACLTools();

    $Token = $_REQUEST ["Token"];
    $status = $_REQUEST ["status"];
    $OrderId = rand(1000000, 100000000);
    $TerminalNo = $_REQUEST ["TerminalNumber"];
    $Amount = $objAclTools->strReplace($_REQUEST ["Amount"], ",");
    $RRN = $_REQUEST ["RRN"];
    $RefNum = $_REQUEST ["RefNum"];

    $UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));

    $SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
    $stdProfile = $objORM->Fetch($SCondition, 'GroupApiId', TableIWUser);

    $apiMainName = 'Agency?$filter=Id%20eq%20' . $stdProfile->GroupApiId;
    $Enabled = BoolEnum::BOOL_TRUE();

    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");
    $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);
    $arrGroupData = $objGlobalVar->ObjectJsonToSelectArray($objKMN->GetWithFilter(), 1);

    if ($arrGroupData[0]->TerminalNumber == null) {
        $GroupIdKey = $stdProfile->GroupIdKey;
        $SCondition = "IdKey = '$GroupIdKey' and  Enabled = '$Enabled' ";
        $arrGroupData[] = $objORM->Fetch($SCondition, 'TerminalNumber,Username,Password', TableIWUserGroup);


    }


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://cut.pec.ir/ApiServices/Api/IPG/ConfirmTxn',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
  "TerminalNumber": ' . (int)$arrGroupData[0]->TerminalNumber . ',
  "Username": "' . (string)$arrGroupData[0]->Username . '",
  "Password": "' . (string)$arrGroupData[0]->Password . '",
  "Amount": ' . (int)$Amount . ',
  "RefNum": "' . $RefNum . '",
  "Token": "' . $Token . '"
  
}',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic cC5hbWlyYW5pOjEyMzQ=',
            'Content-Type: application/ijson',
            'Cookie: cookiesession1=068DEF6AMEOLBCRPXIZGYFC9N7PNB702'
        ),
    ));

    $response = curl_exec($curl);


    curl_close($curl);

    $objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

// user profile
    $Enabled = BoolEnum::BOOL_TRUE();
    $UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
    $SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
    $stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);
    $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

    $arrPost = array('Customer_Id' => (int)$stdProfile->ApiId, 'Amount' => (int)$Amount, 'Token' => (string)$Token, 'Status' => 0, 'OrderId' => (int)$OrderId, 'TerminalNumber' => (int)$TerminalNo, 'RRN' => (int)$RRN);
    $JsonPostData = $objAclTools->JsonEncode($arrPost);

    $objKMN->Post($JsonPostData);

    $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
    JavaTools::JsTimeRefresh(0, '?ln=&part=Report&page=Transaction');
    exit();
}

if (@$_GET['backset'] == 'pep') {

    $strRedirect = 'https://tanjameh.com/ipanel/user.php?ln=&backset=pep&Amount=' . $Amount;

    try {

        $objPasargadIPG = new \Pasargad\Pasargad(5064387, 2316655, $strRedirect, IW_DEFINE_FROM_PANEL . "conf/pepipg.txt");
        // send to pasargad ipg
        $objVerifyData = $objPasargadIPG->verifyPayment();

        // user profile
        $Enabled = BoolEnum::BOOL_TRUE();
        $UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
        $SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
        $stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);
        $objKMN = new KMNConnection($objFileToolsInit->KeyValueFileReader()['MainApi'] . $apiMainName, $objFileToolsInit->KeyValueFileReader()['ApiAuto']);

        $arrPost = array('Customer_Id' => (int)$stdProfile->ApiId, 'Amount' => (int)$Amount, 'Token' => (string)$Token, 'Status' => 0, 'OrderId' => (int)$OrderId, 'TerminalNumber' => (int)$TerminalNo, 'RRN' => (int)$RRN);
        $JsonPostData = $objAclTools->JsonEncode($arrPost);

        $objKMN->Post($JsonPostData);

        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, '?ln=&part=Report&page=Transaction');
        exit();


    } catch (\Exception $ex) {
        var_dump($ex->getMessage());
        die();
    }


}