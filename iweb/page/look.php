<?php
//web look 

$_SESSION['gender'] = str_ireplace('%20',' ',$_GET['gender']);
$_SESSION['category'] = str_ireplace('%20',' ',$_GET['category']);
$_SESSION['group'] = str_ireplace('%20',' ',$_GET['group']);

$_SESSION['page_name_system'] = 'look';
$_SESSION['actual_link'] =  "?gender=".$_GET['gender']."&category=".$_GET['category']."&group=".$_GET['group'];


(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'mobile_view');
(new FileCaller)->FileIncluderWithControler('./iweb', 'look', 'look', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'title_adver_1', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'brand_box', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'trend_categories', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down');