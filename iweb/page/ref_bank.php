<?php
//web index 

$_SESSION['page_name_system'] = 'ref_bank';

(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'top_checkou');
(new FileCaller)->FileIncluderWithControler('./iweb', 'user', 'ref_bank', '0');
(new FileCaller)->FileIncluderWithControler('./iweb', 'temp', 'down_checkou');