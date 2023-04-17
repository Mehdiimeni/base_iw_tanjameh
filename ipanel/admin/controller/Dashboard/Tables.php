<?php
//Tables.php
require IW_ASSETS_FROM_PANEL . "include/DBLoader.php";
$Enabled = BoolEnum::BOOL_TRUE();

//table name
$strTablesName = '';
foreach ((new ACLTools())->TableNames() as $TableNameList) {
    $strTablesName .= '<b>' . $TableNameList . '</b><br />';
}

$strModifyTitle = FA_LC["add"];


if (isset($_POST['SubmitM']) and @$objGlobalVar->RefFormGet()[0] == null) {
    $objAclTools = new ACLTools();

    if ($objAclTools->CheckNull($objAclTools->PostVarToJson())) {
        JavaTools::JsAlertWithRefresh(FA_LC['login_field_null_error'], 0, '');
        exit();
    } else {

        $NameInDB = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->NameInDB);
        $Name = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Name);
        $Columns = $objAclTools->CleanStr($objAclTools->JsonDecode($objAclTools->PostVarToJson())->Columns);

        $arrColumns = explode(',', $Columns);

        $FOpen = fopen(IW_DEFINE_FROM_PANEL . 'conf/tables.iw', 'a+');
        fwrite($FOpen, "$Name\n");
        fclose($FOpen);

        $FOpen = fopen(IW_DEFINE_FROM_PANEL . 'conf/tablename.php', 'a+');
        fwrite($FOpen, "const $Name = \"$NameInDB\";\n");
        fclose($FOpen);

        $objORM->CreateTabl($NameInDB, $arrColumns);
        $strGlobalVarLanguage = @$objGlobalVar->JsonDecode($objGlobalVar->GetVarToJson())->ln;
        JavaTools::JsTimeRefresh(0, $objGlobalVar->setGetVar('ln', @$strGlobalVarLanguage, array('modify')));
        exit();


    }


}


