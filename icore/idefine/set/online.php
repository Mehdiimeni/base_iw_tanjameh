<?php
if (isset($_POST['SubmitAddData'])) {

    $strListDB = trim($_POST['DB']);
    $strListDB = str_replace(' ', '', $strListDB);
    $strListDB = preg_replace('/\s+/', '', $strListDB);
    $arrList = explode(";", $strListDB);
    $FOpen = fopen($this->DefineRoot . 'conf/online.iw', 'x');

    $arrList[0] = base64_encode(base64_encode($arrList[0]));
    $arrList[1] = base64_encode(base64_encode($arrList[1]));
    $arrList[2] = base64_encode(base64_encode($arrList[2]));
    $arrList[3] = base64_encode(base64_encode($arrList[3]));
    $arrList[4] = base64_encode(base64_encode($arrList[4]));
    $arrList[5] = base64_encode(base64_encode($arrList[5]));

    fwrite($FOpen, "Host::==::$arrList[0]\n");
    fwrite($FOpen, "Database::==::$arrList[1]\n");
    fwrite($FOpen, "User::==::$arrList[2]\n");
    fwrite($FOpen, "Password::==::$arrList[3]\n");
    fwrite($FOpen, "IP::==::$arrList[4]\n");
    fwrite($FOpen, "Port::==::$arrList[5]\n");

    fclose($FOpen);

    echo('<meta http-equiv="refresh" content="0;URL=">');
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>IW online DB</title>
</head>

<body>
<form id="form1" name="form1" method="post">

    <p>
        <label for="textarea">IW online DB (;) </label>
        <br/>
        <textarea name="DB" rows="3" cols="100" id="textarea">host;db name;user;pass;ip;port</textarea>
    </p>
    <p>
        <input type="reset" name="reset" id="reset" value="Reset">
        <input type="submit" name="SubmitAddData" id="submit" value="Submit">
    </p>
</form>
</body>
</html>
