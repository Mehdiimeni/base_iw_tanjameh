<?php
//web gender 
$_SESSION['gender'] = @$_GET['gender'];

if ($_GET['gender'] == strtolower('men'))
     $_SESSION['page_name_system'] = 'MenFirstPage';

if ($_GET['gender'] == strtolower('women'))
     $_SESSION['page_name_system'] = 'WomenFirstPage';

if ($_GET['gender'] == strtolower('sale'))
     $_SESSION['page_name_system'] = 'SaleFirstPage';


if ($_GET['gender'] == strtolower('child'))
     $_SESSION['page_name_system'] = 'ChildFirstPage';



(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'mobile_view');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'banner_adver_1', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'banner_adver_2', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'sp_adver_1', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'banner_adver_3', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'sp_adver_2', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'brand_box', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'trend_categories', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'newsletter', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down');