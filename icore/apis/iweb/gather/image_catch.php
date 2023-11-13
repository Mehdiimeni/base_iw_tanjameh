<?php

require_once "../global/CommonInclude.php";

$objFileToolsInit = new FileTools("../../../idefine/conf/init.iw");
$objShowFile = new ShowFile($objFileToolsInit->KeyValueFileReader()['MainName']);
$objShowFile->SetRootStoryFile('../../../../irepository/img/');



if ($objORM->DataExist("AdminOk = 0 and Content IS NULL and listImageUrl IS NOT NULL and listImageUrl != '' ", TableIWAPIProducts, 'id')) {




    foreach ($objORM->FetchAll("AdminOk = 0 and Content IS NULL and listImageUrl IS NOT NULL and listImageUrl != '' ", 'listImageUrl,ProductId', TableIWAPIProducts) as $ListImage) {


        $arrImage = json_decode($ListImage->listImageUrl, true);



        $ProductId = $ListImage->ProductId;

        $arrImageName = array();
        foreach ($arrImage as $ProductImage) {


            $ch = curl_init('https://' . $ProductImage['url'] . '?wid=1400');
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

            if ($content !== false) {
                $FileNewName = $objShowFile->FileSetNewName('webp');
                $arrImageName[] = $FileNewName;

                $file_path = '../../../../irepository/img/attachedimage/' . $FileNewName;

                $fp = fopen($file_path, "wb");

                if ($fp !== false) {
                    fwrite($fp, $content);

                    fclose($fp);

                    $fp = fopen($file_path, "rb");
                    fclose($fp);
                }
            }



        }

        $strImages = implode("==::==", $arrImageName);
        $UCondition = " ProductId = $ProductId ";
        $USet = "Content = '$strImages'";

        $objORM->DataUpdate($UCondition, $USet, TableIWAPIProducts);

    }


}





echo json_encode('--image catch--');
