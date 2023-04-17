<div class="row top_tiles" id="TradeViewPart">
<?php
//TradeJson.php
require_once "../vendor/autoload.php";
SessionTools::init();
require_once "../idefine/conf/root.php";
require_once "../idefine/conf/tablename.php";

$objGlobalVar = new GlobalVarTools();
$objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/online.iw"))->KeyValueFileReader();

if ((new IPTools(IW_DEFINE_FROM_PANEL))->getHostAddressLoad() == 'localhost')
    $objFileToolsDBInfo = (new FileTools(IW_DEFINE_FROM_PANEL . "conf/local.iw"))->KeyValueFileReader();

$objORM = new DBORM((new MySQLConnection($objFileToolsDBInfo))->getConn());
$objFileToolsInit = new FileTools(IW_DEFINE_FROM_PANEL . "conf/init.iw");

// user profile
$Enabled = BoolEnum::BOOL_TRUE();


$UserIdKey = $objGlobalVar->JsonDecode($objGlobalVar->getIWVarToJson('_IWUserIdKey'));
$SCondition = "IdKey = '$UserIdKey' and  Enabled = '$Enabled' ";
$stdProfile = $objORM->Fetch($SCondition, 'Name,Image,GroupIdKey,CountEnter,ApiId,GroupApiId', TableIWUser);


$SCondition = "GroupIdKey = '$stdProfile->GroupIdKey'";
$objUserAccess = @$objORM->Fetch($SCondition, 'AllTrade', TableIWUserAccess);
$arrAllTrade = $objGlobalVar->JsonDecodeArray($objUserAccess->AllTrade);


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

            $strTradePosition .= '
    <div class="col-md-3 col-sm-6 col-xs-12">
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
                                    <p>
                                        ' . $objTradePosition->Description . '
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
    ';
        }

    }


}
?>
    <div class="clearfix"></div>

</div>
