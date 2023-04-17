<?php
// SubMenuDataLoader.php



// SubMenu
$SCondition = "Enabled = $Enabled and LocalName != ''  ";
foreach ($objORM->FetchAll($SCondition, 'Name,IdKey', TableIWWebMainMenu) as $MainMenu) {
    $MainName = strtolower($MainMenu->Name);
    $SCondition = " Enabled = $Enabled   and ModifyDate = '$ModifyDateNow' and Main = '$MainName' and TypeSet = 'Product'  GROUP BY Sub ";
    foreach ($objORM->FetchAll($SCondition, '*', TableIWAPIAllCat) as $APIAllCatSub) {

        if (!$objORM->DataExist("GroupIdKey = '$MainMenu->IdKey' and Name = '$APIAllCatSub->Sub' ", TableIWWebSubMenu)) {

            $SubIdKey = $objAclTools->IdKey();

            $InSet = "";
            $InSet .= " IdKey = '$SubIdKey' ,";
            $InSet .= " Enabled = '$Enabled' ,";
            $InSet .= " Name = '$APIAllCatSub->Sub' ,";
            $InSet .= " GroupIdKey = '$MainMenu->IdKey' ,";
            $InSet .= " CompanyIdKey = '4a897b83' ,";
            $InSet .= " CatId = '$APIAllCatSub->CategoryId' ,";
            $InSet .= " ModifyIP = '$ModifyIP' ,";
            $InSet .= " ModifyTime = '$ModifyTime' ,";
            $InSet .= " ModifyDate = '$ModifyDate' ,";
            $InSet .= " ModifyStrTime = '$ModifyStrTime', ";
            $InSet .= " ModifyId = '' ";

            $objORM->DataAdd($InSet, TableIWWebSubMenu);

        } else {

            $USet = "";
            $USet .= " Name = '$APIAllCatSub->Sub' ,";
            $USet .= " GroupIdKey = '$MainMenu->IdKey' ,";
            $USet .= " CompanyIdKey = '4a897b83' ,";
            $USet .= " CatId = '$APIAllCatSub->CategoryId' ,";
            $USet .= " ModifyIP = '$ModifyIP' ,";
            $USet .= " ModifyTime = '$ModifyTime' ,";
            $USet .= " ModifyDate = '$ModifyDate' ,";
            $USet .= " ModifyStrTime = '$ModifyStrTime' ";

            $objORM->DataUpdate("GroupIdKey = '$MainMenu->IdKey' and Name = '$APIAllCatSub->Sub' ", $USet, TableIWWebSubMenu);
        }

        $SCondition = " Enabled = $Enabled   and ModifyDate = '$ModifyDateNow' and Main = '$MainName' and Sub = '$APIAllCatSub->Sub' and TypeSet = 'Product' GROUP BY Sub2 ";
        foreach ($objORM->FetchAll($SCondition, '*', TableIWAPIAllCat) as $APIAllCatSub2) {

            if(!isset($APIAllCatSub2->Sub2))
                continue;

            if (!$objORM->DataExist("GroupIdKey = '$APIAllCatSub->IdKey' and Name = '$APIAllCatSub2->Sub2' ", TableIWWebSub2Menu)) {

                $Sub2IdKey = $objAclTools->IdKey();

                $InSet = "";
                $InSet .= " IdKey = '$Sub2IdKey' ,";
                $InSet .= " Enabled = '$Enabled' ,";
                $InSet .= " Name = '$APIAllCatSub2->Sub2' ,";
                $InSet .= " GroupIdKey = '$SubIdKey' ,";
                $InSet .= " CatId = '$APIAllCatSub2->CategoryId' ,";
                $InSet .= " ModifyIP = '$ModifyIP' ,";
                $InSet .= " ModifyTime = '$ModifyTime' ,";
                $InSet .= " ModifyDate = '$ModifyDate' ,";
                $InSet .= " ModifyStrTime = '$ModifyStrTime', ";
                $InSet .= " ModifyId = '' ";

                $objORM->DataAdd($InSet, TableIWWebSub2Menu);

            } else {

                $USet = "";
                $USet .= " Name = '$APIAllCatSub2->Sub2' ,";
                $USet .= " GroupIdKey = '$APIAllCatSub->IdKey' ,";
                $USet .= " CatId = '$APIAllCatSub2->CategoryId' ,";
                $USet .= " ModifyIP = '$ModifyIP' ,";
                $USet .= " ModifyTime = '$ModifyTime' ,";
                $USet .= " ModifyDate = '$ModifyDate' ,";
                $USet .= " ModifyStrTime = '$ModifyStrTime' ";

                $objORM->DataUpdate("GroupIdKey = '$APIAllCatSub->IdKey' and Name = '$APIAllCatSub2->Sub2' ", $USet, TableIWWebSub2Menu);
            }


            $SCondition = " Enabled = $Enabled   and ModifyDate = '$ModifyDateNow' and Main = '$MainName' and Sub = '$APIAllCatSub->Sub' and Sub2 = '$APIAllCatSub2->Sub2' and TypeSet = 'Product' GROUP BY Sub3 ";
            foreach ($objORM->FetchAll($SCondition, '*', TableIWAPIAllCat) as $APIAllCatSub3) {

                if(!isset($APIAllCatSub3->Sub3))
                    continue;

                if (!$objORM->DataExist("GroupIdKey = '$APIAllCatSub2->IdKey' and Name = '$APIAllCatSub3->Sub3' ", TableIWWebSub3Menu)) {

                    $Sub3IdKey = $objAclTools->IdKey();

                    $InSet = "";
                    $InSet .= " IdKey = '$IdKey' ,";
                    $InSet .= " Enabled = '$Enabled' ,";
                    $InSet .= " Name = '$APIAllCatSub3->Sub3' ,";
                    $InSet .= " GroupIdKey = '$Sub2IdKey' ,";
                    $InSet .= " CatId = '$APIAllCatSub3->CategoryId' ,";
                    $InSet .= " ModifyIP = '$ModifyIP' ,";
                    $InSet .= " ModifyTime = '$ModifyTime' ,";
                    $InSet .= " ModifyDate = '$ModifyDate' ,";
                    $InSet .= " ModifyStrTime = '$ModifyStrTime', ";
                    $InSet .= " ModifyId = '' ";

                    $objORM->DataAdd($InSet, TableIWWebSub3Menu);

                } else {

                    $USet = "";
                    $USet .= " Name = '$APIAllCatSub3->Sub3' ,";
                    $USet .= " GroupIdKey = '$APIAllCatSub2->IdKey' ,";
                    $USet .= " CatId = '$APIAllCatSub3->CategoryId' ,";
                    $USet .= " ModifyIP = '$ModifyIP' ,";
                    $USet .= " ModifyTime = '$ModifyTime' ,";
                    $USet .= " ModifyDate = '$ModifyDate' ,";
                    $USet .= " ModifyStrTime = '$ModifyStrTime' ";

                    $objORM->DataUpdate("GroupIdKey = '$APIAllCatSub2->IdKey' and Name = '$APIAllCatSub3->Sub3' ", $USet, TableIWWebSub3Menu);
                }

            }


        }



    }
}