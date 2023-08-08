<?php
//web look_creater 
$_SESSION['look'] = @$_GET['look'];


(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'top');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'nav');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'menu');
(new FileCaller)->FileIncluderWithControler('./iweb', 'look', 'banner_creator', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'look', 'closet_creator', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'look', 'look_creator', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'look', 'look_footer', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'global', 'footer');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down');