<?php

include_once("mysql.php");
include_once("asos.php");
include_once("gather_model.php");
include_once("storage.php");

$database = Database::getInstance();
$db = $database->getConnection();

$gather = new Gather($db);

// get list of cat id

$allProductNoImageResult = $gather->getProductNoImage();




while ($allProductNoImageDetails = $allProductNoImageResult->fetch_assoc()) {


    $arrImage = array();
    $product_id = $allProductNoImageDetails["id"];
    $allImageResult = $gather->getImage($product_id);

    while ($allImageDetails = $allImageResult->fetch_assoc()) {



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://' . $allImageDetails["url"] . '?wid=1400');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_WHATEVER);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 40);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        $content = curl_exec($ch);
        curl_close($ch);


        $FileNewName = $objShowFile->FileSetNewName('webp');
        $arrImage[] = $FileNewName;


        $fp = fopen('../irepository/img/attachedimage/' . $FileNewName, "x");
        fwrite($fp, $content);
        fclose($fp);

    }


    $strImages = implode("==::==", $arrImage);

    $gather->productImageNameUpdate($product_id,$strImages);
                             
exit();
}

echo ("<br /> <<<<<<<<<<< IMAGE GET >>>>>>>>>>>>>>>");


?>