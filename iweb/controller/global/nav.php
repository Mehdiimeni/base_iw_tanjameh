<?php
///controller/global/nav.php

$objACL = new ACLTools();

function get_nav()
{ 
    include dirname(__FILE__,4) . "/iassets/include/DBLoader.php";
    $Enabled = BoolEnum::BOOL_TRUE();

   return  @$objORM->FetchAll(" Enabled = $Enabled ", '*', TableIWNewMenu);
}




