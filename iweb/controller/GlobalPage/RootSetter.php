<?php
// MainDataLoader.php
$intResult = 0 ;
foreach ($objORM->FetchAll(1, 'Name,ApiId', TableIWWebMainMenu) as $MainRoot) {

    $PGender = $MainRoot->Name;
    $PGenderId = $MainRoot->ApiId;
    $MainGroupIdKey  = $MainRoot->IdKey;
    $SCondition = " GroupIdKey = '$MainGroupIdKey' ";
    foreach ($objORM->FetchAll($SCondition, 'Name,ApiId,ApiCategoryId', TableIWWebSubMenu) as $SubMenu ) {

        $PCategory = $SubMenu->Name;
        $PCategoryId = $SubMenu->ApiId;
        $SubMenuGroupIdKey  = $SubMenu->IdKey;
        $SCondition2 = " GroupIdKey = '$SubMenuGroupIdKey' ";

        foreach ($objORM->FetchAll($SCondition2, 'Name,ApiId,ApiCategoryId,CatId', TableIWWebSub2Menu) as $Sub2Menu ) {

            $PGroup = $Sub2Menu->Name;
            $PGroupId = $Sub2Menu->ApiId;
            $ApiCategoryId = $Sub2Menu->ApiCategoryId;
            $CatId = $Sub2Menu->CatId;

            $UCondition = " ApiCategoryId = '$ApiCategoryId' and CatId = '$CatId' ";

            $USet = " PCategory = '$PCategory' ,";
            $USet .= " PGroup = '$PGroup' ,";
            $USet .= " PGenderId = '$PGenderId' ,";
            $USet .= " PGender = '$PGender' ,";
            $USet .= " PCategoryId = '$PCategoryId' ,";
            $USet .= " PGroupId = '$PGroupId' ,";
            $USet .= " modify_ip = '$modify_ip' ,";
            
            
            $USet .= " last_modify = '$now_modify'";


          $strResult =  $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

          if ($strResult)
              $intResult++;

        }

    }
}
