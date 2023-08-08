<?php
///controller/look/banner_creator.php
function banner_creator_info($look_id)
{
    $filds = array(
        'look_id' => $look_id
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/banner_creator_info', $filds));

}

function look_creator_info($look_id){
    $filds = array(
        'look_id' => $look_id
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_creator_info', $filds));

}

function closet_creator_info($look_id){
    $filds = array(
        'look_id' => $look_id
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/closet_creator_info', $filds));

}