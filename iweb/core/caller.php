<?php

class IWebFileCaller 
{
    public function FileIncluderWithControler($FullDirAddress, $NameFolder, $Name, $TypeInclude = 'requre')
    {

        $this->FileLocationExist($FullDirAddress , '/controller/' , $NameFolder.'/',$Name . '.php');
        $this->FileLocationExist($FullDirAddress , '/template/' , $NameFolder.'/',$Name . '.php');
        $this->FileLocationExist($FullDirAddress , '/view/' , $NameFolder.'/',$Name . '.php');

        //require_once $FullDirAddress . 'controller/' . $NameFolder . '/'. $Name . '.php';
        if($TypeInclude == 'requre'){
        require_once $FullDirAddress . '/view/' . $NameFolder . '/'. $Name . '.php';
        }else
        {
            include_once $FullDirAddress . '/view/' . $NameFolder . '/'. $Name . '.php';

        }

    }

    public  function FileModifyIncluderWithControler($FullDirAddress, $NameFolder, $Name, $TypeModify, $TypeInclude = 'requre')
    {
        $this->FileLocationExist($FullDirAddress , '/controller/' , $NameFolder.'/',$Name . 'Modify.php');
        $this->FileLocationExist($FullDirAddress , '/template/' , $NameFolder.'/',$Name . 'Modify.php');
        $this->FileLocationExist($FullDirAddress , '/view/' , $NameFolder.'/',$Name . 'Modify.php');

        //require_once $FullDirAddress . 'controller/' . $NameFolder . '/'. $Name . 'Modify.php';
        if($TypeInclude == 'requre'){
        require_once $FullDirAddress . '/view/' . $NameFolder . '/'. $Name . 'Modify.php';
        }else{
            include_once $FullDirAddress . '/view/' . $NameFolder . '/'. $Name . 'Modify.php';

        }
    }

    public function FileLocationExist($FullDirAddress,$Taype ,$NameFolder, $NameFile)
    {


        if (!file_exists($FullDirAddress.$Taype.$NameFolder)) {
            mkdir($FullDirAddress.$Taype.$NameFolder, 0755, true);
        }

        if (!file_exists($FullDirAddress.$Taype .$NameFolder. $NameFile)) {
            $FOpen = fopen($FullDirAddress.$Taype .$NameFolder. $NameFile, 'x');
            fwrite($FOpen, "<?php\n");
            fwrite($FOpen, "//$Taype$NameFolder$NameFile\n");

            if($Taype == '/template/')
            {
                fwrite($FOpen, "?>\n"); 
            }

            if($Taype == '/view/')
            {
                fwrite($FOpen,"require_once '../../../controller/$NameFolder$NameFile');\n");
                fwrite($FOpen,"require_once '../../../template/$NameFolder$NameFile');\n");
            }

            fclose($FOpen);
        }

    }
}