<?php
///controller/gather/image_catch.php
function image_catch()
{
    $objIAPI = set_server();
    $filds = array(
        'iw_company_id'=> 1 //asos
    );
    return $objIAPI->GetPostApi('gather/image_catch', $filds);
}