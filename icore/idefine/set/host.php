<?php
if (isset($_POST['SubmitAddData'])) {

    $strListHost = trim($_POST['Host']);
    $strListHost = str_replace(' ', '', $strListHost);
    $strListHost = preg_replace('/\s+/', '', $strListHost);

    $FOpen = fopen($this->DefineRoot . 'conf/host.iw', 'x');
    fwrite($FOpen, "localhost\n");
    fwrite($FOpen, "127.0.0.1\n");

    foreach (explode(";", $strListHost) as $ListHost) {

        fwrite($FOpen, "$ListHost\n");

    }

    fclose($FOpen);

    echo('<meta http-equiv="refresh" content="0;URL=">');
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>IW Host</title>
</head>

<body>
<form id="form1" name="form1" method="post">
    <p>
        <label for="textarea">IW Host (;) - localhost is defult</label>
        <br/>
        <textarea name="Host" rows="3" cols="100" id="textarea"></textarea>
    </p>
    <p>
        <input type="reset" name="reset" id="reset" value="Reset">
        <input type="submit" name="SubmitAddData" id="submit" value="Submit">
    </p>
</form>
</body>
</html>
