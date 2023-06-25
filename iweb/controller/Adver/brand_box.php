<?php
///controller/adver/brand_box.php
isset($_SESSION['gender']) ? $gender = strtolower(@$_SESSION['gender']) : $gender = '';
$gender_title = _LANG['brands'];

switch ($gender) {
    case 'men':
        $gender_title = _LANG['men_brands'];
        break;
    case 'women':
        $gender_title = _LANG['women_brands'];
        break;
    case 'sale':
        $gender_title = _LANG['sale_brands'];
        break;
    case 'child':
        $gender_title = _LANG['child_brands'];
        break;

}

function get_brand($gender)
{
    $objIAPI = set_server();
    $filds = array('gender' => $gender);
    return json_decode($objIAPI->GetPostApi('adver/adver_brand', $filds));

}