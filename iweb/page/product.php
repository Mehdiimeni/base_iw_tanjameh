<?php
//web group 

$_SESSION['item'] = $_GET['item'];
$_SESSION['page_name_system'] = 'product';

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top_product');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'mobile_view');
(new FileCaller)->FileIncluderWithControler('./iweb', 'product', 'product', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'related_adver_1', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'related_adver_2', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'related_adver_3', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'brand_box', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'adver', 'trend_categories', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down_product');