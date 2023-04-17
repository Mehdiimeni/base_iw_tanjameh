<?php

if (isset($_POST['SubmitAddData'])) {

    $strList = trim($_POST['Result']);
    $strList = str_replace(' ', '', $strList);
    $strList = preg_replace('/\s+/', '', $strList);
    $arrList = explode(";", $strList);

    $FOpen = fopen($this->DefineRoot . 'conf/init.iw', 'x');

    fwrite($FOpen, "MemoryLimit::==::$arrList[0]\n");
    fwrite($FOpen, "Language::==::$arrList[1]\n");
    fwrite($FOpen, "TimeZone::==::$arrList[2]\n");
    fwrite($FOpen, "Encoding::==::$arrList[3]\n");
    fwrite($FOpen, "Protocol::==::$arrList[4]\n");
    fwrite($FOpen, "MainName::==::$arrList[5]\n");
    fwrite($FOpen, "MainDomain::==::$arrList[6]\n");

    fclose($FOpen);

    echo('<meta http-equiv="refresh" content="0;URL=">');
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>IW INIT</title>
</head>

<body>
<form id="form1" name="form1" method="post">
    <p>
        <label for="textarea">IW INIT </label>
        <br/>
        <textarea name="Result" rows="3" cols="100" id="textarea">800M;fa;Asia/Tehran;UTF-8;Https;borobe;.com</textarea>
    </p>
    <p>
        <input type="reset" name="reset" id="reset" value="Reset">
        <input type="submit" name="SubmitAddData" id="submit" value="Submit">
    </p>
</form>
</body>
</html>
