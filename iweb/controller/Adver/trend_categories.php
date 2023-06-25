<?php
///controller/adver/trend_categories.php
$gender = strtolower($_SESSION['gender']);
$gender_category_title = _LANG['categories'];

switch ($gender) {
    case 'men':
        $gender_category_title = _LANG['men_category'];
        break;
    case 'women':
        $gender_category_title = _LANG['women_category'];
        break;
    case 'sale':
        $gender_category_title = _LANG['sale_category'];
        break;
    case 'child':
        $gender_category_title = _LANG['child_category'];
        break;

}

function get_adver_category($gender)
{
    $objIAPI = set_server();
    $filds = array('gender' => $gender);
    return json_decode($objIAPI->GetPostApi('adver/adver_category', $filds));

}