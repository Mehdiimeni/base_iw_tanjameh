<?php

include_once("mysql.php");
include_once("asos.php");
include_once("gather_model.php");

$database = Database::getInstance();
$db = $database->getConnection();

$gather = new Gather($db);

// get list of cat id

$allProductNewResult = $gather->getAllProductNew();



while ($allProductNewDetails = $allProductNewResult->fetch_assoc()) {


    $ListProductNewDetails = json_decode($allProductNewDetails["list_products"], true);

    foreach ($ListProductNewDetails as $ListProductDetails) {

        $gather->addImage($ListProductDetails);

    }

}

echo("<br /> <<<<<<<<<<< IMAGE UPDATE >>>>>>>>>>>>>>>");


?>