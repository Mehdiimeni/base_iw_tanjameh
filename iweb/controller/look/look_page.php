<?php
///controller/look/look_page.php
function user_look_page($file_all_data,$post_all_data)
{
    $filds = array(
        'look_page_profile' => $file_all_data['look_page_profile'],
        'look_page_banner' => $file_all_data['look_page_banner'],
        'look_page_name' => $post_all_data['look_page_name'],
        'look_page_discription' => $post_all_data['look_page_discription'],
        'look_page_color' => $post_all_data['look_page_color'],
        'closet' => $post_all_data['closet'],
        'user_id' =>(int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_page', $filds));
}

function user_look_page_info()
{
    $filds = array(
        'user_id' =>(int) base64_decode($_COOKIE['user_id'])
    );

    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('look/look_page_info', $filds));
}