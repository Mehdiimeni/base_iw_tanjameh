<?php
//web group 

$_SESSION['gender'] = $_GET['gender'];
$_SESSION['category'] = $_GET['category'];
$_SESSION['group'] = $_GET['group'];
$_SESSION['cat_id'] = $_GET['CatId'];

$_SESSION['page_name_system'] = 'group';
$_SESSION['actual_link'] =  "?gender=".$_GET['gender']."&category=".$_GET['category']."&group=".$_GET['group']."&CatId=".$_GET['CatId'];


(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'mobile_view');
(new FileCaller)->FileIncluderWithControler('./iweb', 'product', 'group', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'title_adver_1', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'brand_box', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'trend_categories', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down');