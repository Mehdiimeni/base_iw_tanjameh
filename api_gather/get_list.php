<?php

include_once("mysql.php");
include_once("asos.php");
include_once("gather_model.php");

$database = Database::getInstance();
$db = $database->getConnection();

$gather = new Gather($db);

if($gather->getCountCatId()["count"]> 0){
$objAsos = new AsosConnections();

// get list of cat id


$allCatIdResult = $gather->getAllCatId();


while ($allCatIdDetails = $allCatIdResult->fetch_assoc()) {


    $ListAsosNewResult = json_decode($objAsos->ProductsListNew($allCatIdDetails["cat_id"]), true);

    foreach ($ListAsosNewResult['facets'] as $arrFacets) {

        if ($arrFacets['id'] == "freshness_band"){

            foreach ($arrFacets['facetValues'] as $arrFacetValues) {
            
                if ($arrFacetValues['name'] == "Today"){

                    $itemLimit = $arrFacetValues['count'];
                }
            
            }
        }
    }

    $allListAsosResult = json_decode($objAsos->ProductsList($allCatIdDetails["cat_id"],$itemLimit), true);

    //update count_all list 
    $gather->itemCountUpdate($allCatIdDetails["cat_id"], $itemLimit, json_encode($allListAsosResult["products"]));

    /*
    foreach ($allListAsosResult["products"] as $productDetails) {

        $gather->addProduct($productDetails, $allCatIdDetails["cat_id"]);
        $gather->addImage($productDetails);
    }
    */

}

}else{
    echo("<<<<<<<<<<< LIST UPDATE >>>>>>>>>>>>>>>");
}

?>