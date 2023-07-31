<?php
///controller/user/myaccount_details.php
function user_edit_profile($post_all_data)
{
    $filds = array(
        'user_id' =>(int) base64_decode($_COOKIE['user_id']),
        'Name' => $post_all_data['Name'],
        'CellNumber' => $post_all_data['CellNumber'],
        'NationalCode' => $post_all_data['NationalCode'],
        'Fashionpreference' => $post_all_data['Fashionpreference']
        );
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/edit_profile', $filds));

}

function user_profile()
{
    $filds = array(
        'user_id' =>(int) base64_decode($_COOKIE['user_id'])
        );
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/profile', $filds));
}