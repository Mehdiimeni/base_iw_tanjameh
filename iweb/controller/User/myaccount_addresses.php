<?php
///controller/user/myaccount_addresses.php
function user_adress($post_all_data)
{


    $filds = array(
        'NicName' => $post_all_data['NicName'],
        'gender' => $post_all_data['gender'],
        'name' => $post_all_data['name'],
        'family' => $post_all_data['family'],
        'iw_country_id' => $post_all_data['iw_country_id'],
        'PostCode' => $post_all_data['PostCode'],
        'OtherTel' => $post_all_data['OtherTel'],
        'city' => $post_all_data['city'],
        'Address' => $post_all_data['Address'],
        'Description' => $post_all_data['Description'],
        'is_default' => $post_all_data['is_default'],
        'user_id' =>(int) base64_decode($_COOKIE['user_id'])
    );
        
    $objIAPI = set_server();
    return json_decode($objIAPI->GetPostApi('user/add_address', $filds));

}


function get_countreis()
{
    $objIAPI = set_server();
    return json_decode($objIAPI->GetGeneralApi('global/countreis'));
}

function get_user_address()
{

    if ( base64_decode($_COOKIE['user_id']) == null) {
        return false;
    } else {
        $filds = array('user_id' =>(int) base64_decode($_COOKIE['user_id']));
        $objIAPI = set_server();
        return json_decode($objIAPI->GetPostApi('user/address', $filds));

    }

}