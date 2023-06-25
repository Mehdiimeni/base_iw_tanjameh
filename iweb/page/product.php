<?php
//web group 

$_SESSION['key_id'] = $_GET['id'];
$_SESSION['page_name_system'] = 'product';

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'mobile_view');
(new FileCaller)->FileIncluderWithControler('./iweb', 'product', 'product', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'sp_adver_1', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'sp_adver_2', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'sp_adver_3', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'sp_adver_4', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'brand_box', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'trend_categories', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down');