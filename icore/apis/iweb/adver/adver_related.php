<?php
require_once "../global/CommonInclude.php";

$color_related = "رنگ ها";
$color_related_note = "موارد مشابه بر اساس رنگ";
$price_related = "قیمت";
$price_related_note = "موارد مشابه بر اساس قیمت";
$group_related = "انواع";
$group_related_note = "موارد مشابه بر اساس نوع";

if (!empty($_POST['adver_related'])) {

    $adver_related = $_POST['adver_related'];

    switch ($adver_related) {
        case 'color':
            $title = $color_related;
            $content = $color_related_note;
            break;

        case 'group':
            $title = $group_related;
            $content = $group_related_note;
            break;

        case 'price':
            $title = $price_related;
            $content = $price_related_note;
            break;
    }

    $arr_related_details = array(
        'title' => $title,
        'content' => $content,
    );

    echo json_encode($arr_related_details);

} else {
    echo false;
}